<?php
declare(strict_types=1);

use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Factories\GitHashFinderFactory;
use TJVB\GitHash\Retrievers\Retriever;

require_once 'vendor/autoload.php';

// we take the root from the project as example path
$path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

/**
 * This example use the default finder factory with the default finders to see a very basic option
 */
try {
    $retriever = Retriever::getWithFactory(GitHashFinderFactory::withDefaultFinders());
    echo $retriever->getHash($path)->hash() . PHP_EOL;
} catch (GitHashException $exception) {
    echo 'Failed to get the hash ' .  $exception->getMessage() . PHP_EOL;
}

/**
 * This example looks the same as above with the difference that if a finder is available but fails to load the hash it will try the next one.
 */
try {
    $retriever = Retriever::getWithFactory(GitHashFinderFactory::withDefaultFinders());
    echo $retriever->getHashAndIgnoreFailures($path)->hash() . PHP_EOL;
} catch (GitHashException $exception) {
    echo 'Failed to get the hash ' .  $exception->getMessage() . PHP_EOL;
}

