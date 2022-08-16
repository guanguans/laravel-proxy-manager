# package-skeleton

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> A PHP package template repository. - 一个 PHP 软件包模板存储库。

[![tests](https://github.com/guanguans/laravel-proxy-manager/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![check & fix styling](https://github.com/guanguans/laravel-proxy-manager/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-proxy-manager/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-proxy-manager)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-proxy-manager/v)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-proxy-manager/downloads)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![License](https://poser.pugx.org/guanguans/laravel-proxy-manager/license)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![Open in Visual Studio Code](https://open.vscode.dev/badges/open-in-vscode.svg)](https://open.vscode.dev/guanguans/laravel-proxy-manager)
![GitHub repo size](https://img.shields.io/github/repo-size/guanguans/laravel-proxy-manager)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/laravel-proxy-manager)

## Features

* Integrated [brainmaestro/composer-git-hooks](https://github.com/BrainMaestro/composer-git-hooks) - Git hooks
* Integrated [brianium/paratest](https://github.com/paratestphp/paratest) - Parallel testing for PHPUnit
* Integrated [codedungeon/phpunit-result-printer](https://github.com/mikeerickson/phpunit-pretty-result-printer) - PHPUnit Pretty Result Printer
* Integrated [dg/bypass-finals](https://github.com/rdohms/dg/bypass-finals) - Unit test assistant package
* Integrated [dms/phpunit-arraysubset-asserts](https://github.com/rdohms/phpunit-arraysubset-asserts) - Unit test assistant package
* Integrated [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) - Unit test
* Integrated [bovigo/vfsStream](https://github.com/bovigo/vfsStream) - Unit test assistant package
* Integrated [mockery/mockery](https://github.com/mockery/mockery) - Mock
* Integrated [Nyholm/NSA](https://github.com/Nyholm/NSA) - Unit test assistant package
* Integrated [phpbench/phpbench](https://github.com/phpbench/phpbench) - Benchmarks  
* Integrated [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) - Coding standard check
* Integrated [johnkary/phpunit-speedtrap](https://github.com/johnkary/phpunit-speedtrap) - Reports on slow-running tests in your PHPUnit test suite
* Integrated [overtrue/phplint](https://github.com/overtrue/phplint) - Grammar check
* Integrated [symplify/monorepo-builder](https://github.com/symplify/monorepo-builder) - Monorepo
* Integrated [vimeo/psalm](https://github.com/vimeo/psalm) - Static check
* Integrated [lint-md/lint-md](https://github.com/lint-md/lint-md) - Markdown grammar check
* Integrated [povils/phpmnd](https://github.com/povils/phpmnd) - PHP Magic Number Detector
* With IDE helper file
* With `github/pages` docsify [documentation site](https://guanguans.github.io/package-skeleton/)
* With common badge icons
* With Chinese and English `README.md` file

## Requirement

* PHP >= 7.2

## Installation

```bash
$ composer require guanguans/laravel-proxy-manager --prefer-dist -vvv
```

## Usage

1. execute `$ git clone https://github.com/guanguans/laravel-proxy-manager.git`
2. replace `guanguans/laravel-proxy-manager` -> `vendorName/package-name`
3. replace `Guanguans\\LaravelProxyManager` -> `VendorName\\PackageName`
4. replace `Guanguans\LaravelProxyManager` -> `VendorName\PackageName`
5. replace `ityaozm@gmail.com` -> `your email`
6. execute `$ composer install && composer dumpautoload`  
7. execute `$ rm .git/`
8. execute `$ git init && git add . && git commit -m 'Build the basic skeleton'`

## Testing

```bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
