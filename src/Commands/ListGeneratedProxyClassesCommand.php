<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeFinder;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ListGeneratedProxyClassesCommand extends Command
{
    protected $signature = 'proxy:list
                            {--m|parse-mode=1 : The mode(1,2,3,4) to use for the PHP parser}
                            {--M|memory-limit= : The memory limit to use for the PHP parser}';

    protected $description = 'List generated proxy classes.';

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->option('memory-limit') and ini_set('memory_limit', $this->option('memory-limit'));

        $this->laravel->bind(Parser::class, function () {
            return (new ParserFactory())->create((int) $this->option('parse-mode'));
        });
    }

    public function handle(Parser $parser, NodeFinder $nodeFinder): int
    {
        if (! file_exists($proxiesDir = config('proxy-manager.generated_proxies_dir'))) {
            $this->warn('Proxy classes directory not found.');

            return static::SUCCESS;
        }

        $fileInfos = Finder::create()
            ->in($proxiesDir)
            ->files()
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->ignoreUnreadableDirs();

        collect($fileInfos)
            ->transform(function (SplFileInfo $fileInfo) use ($parser, $nodeFinder) {
                $proxyInfos = [];

                try {
                    $nodes = $parser->parse($fileInfo->getContents());
                } catch (Error $e) {
                    $this->error(sprintf('The file of %s parse error: %s.', $fileInfo->getRealPath(), $e->getMessage()));

                    return $proxyInfos;
                }

                $classNodes = $nodeFinder->find($nodes, function (Node $node) {
                    return $node instanceof Class_
                            && $node->name
                            && Str::startsWith($node->name->toString(), 'Generated');
                });

                /** @var Class_ $classNode */
                foreach ($classNodes as $classNode) {
                    $proxyInfos[] = [
                        'index' => null,
                        'original_class' => implode('\\', $classNode->extends->parts),
                        'proxy_class' => $classNode->name->toString(),
                        'proxy_type' => Str::of(end($classNode->implements[0]->parts))
                            ->replaceLast('Interface', '')
                            ->snake()->replace('_', ' ')
                            ->title(),
                    ];
                }

                return $proxyInfos;
            })
            ->flatten(1)
            ->filter()
            ->map(function (array $proxyInfo, $index) {
                $proxyInfo['index'] = ++$index;

                return $proxyInfo;
            })
            ->whenEmpty(function (Collection $proxyInfos) {
                $this->warn('No generated proxy classes found.');

                return $proxyInfos;
            })
            ->whenNotEmpty(function (Collection $proxyInfos) {
                $this->table(array_map(function ($name) {
                    return Str::of($name)->snake()->replace('_', ' ')->title();
                }, array_keys($proxyInfos[0])), $proxyInfos);

                return $proxyInfos;
            });

        return static::SUCCESS;
    }
}
