# GitHash


[![Latest Stable Version](https://poser.pugx.org/tjvb/githash/v)](https://packagist.org/packages/tjvb/githash)
[![Pipeline status](https://gitlab.com/tjvb/githash/badges/master/pipeline.svg)](https://gitlab.com/tjvb/githash/-/pipelines?page=1&scope=all&ref=master)
[![Coverage report](https://gitlab.com/tjvb/githash/badges/master/coverage.svg)](https://gitlab.com/tjvb/githash/-/pipelines?page=1&scope=all&ref=master)
[![Tested on PHP 8.0 to 8.2](https://img.shields.io/badge/Tested%20on-PHP%208.0%20|%208.1%20|%208.2-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/githash/-/pipelines?page=1&scope=all&ref=master)
[![Latest Unstable Version](https://poser.pugx.org/tjvb/githash/v/unstable)](https://packagist.org/packages/tjvb/githash)


[![PHP Version Require](https://poser.pugx.org/tjvb/githash/require/php)](https://packagist.org/packages/tjvb/githash)
[![PHPMD](https://img.shields.io/badge/PHPMD-checked-brightgreen.svg)](https://gitlab.com/tjvb/githash/-/blob/master/phpmd.xml.dist)
[![PHPStan](https://img.shields.io/badge/PHPStan-checked-brightgreen.svg)](https://gitlab.com/tjvb/githash/-/blob/master/phpstan.neon.dist)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg)](https://gitlab.com/tjvb/githash/-/blob/master/phpcs.xml.dist)


[![License](https://poser.pugx.org/tjvb/githash/license)](https://packagist.org/packages/tjvb/githash)

This package is intended to give a usefull option for getting the hash from the current commit.

## Usage
```php
try {
    $retriever = Retriever::getWithFactory(GitHashFinderFactory::withDefaultFinders());
    echo $retriever->getHash($path)->hash() . PHP_EOL;
} catch (GitHashException $exception) {
    echo 'Failed to get the hash ' .  $exception->getMessage() . PHP_EOL;
}
```

## Examples
See docs/examples for examples about how to use this package.


## Installation
You can install this package with composer by executing the command: `composer require tjvb/githash`.

## Different HashFinders

The package provide 3 different GitHashFinder they all have some pro's and con's.

| GitHashFinder | Requirements | Benefits | Cons|
| --- | --- | --- | --- |
| GitProcessCommandHashFinder | The [symfony/process](https://packagist.org/packages/symfony/process) package and git executable. | This execute the git commands with the symfony/process package to get good feedback. | You need to install this package and have the git command available. |
| GitShellExecCommandHashFinder | The [shell_exec](https://www.php.net/shell_exec) PHP function and git executable. | This execute the git commands. | You need to have shell_exec and the git command available. |
| GitFileSystemHashFinder | A branch. | It reads the git files and doesn't need to have a git executable. | The repository need to have a branch, it doesn't work with a detached head. |

## Laravel package
If you use Laravel you can use [tjvb/laravel-githash](https://gitlab.com/tjvb/laravel-githash), this package can add the hash to your log files and provides a blade component to show the hash.

## Changelog
We (try to) document all the changes in [CHANGELOG](CHANGELOG.md) so read it for more information.

## Contributing
You are very welcome to contribute, read about it in [CONTRIBUTING](CONTRIBUTING.md)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

