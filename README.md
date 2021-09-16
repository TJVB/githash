# GitHash

This package is intended to give a usefull option


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

## Changelog
We (try to) document all the changes in [CHANGELOG](CHANGELOG.md) so read it for more information.

## Contributing
You are very welcome to contribute, read about it in [CONTRIBUTING](CONTRIBUTING.md)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

