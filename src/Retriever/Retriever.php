<?php

declare(strict_types=1);

namespace TJVB\GitHash\Retriever;

use Exception;
use TJVB\GitHash\Contracts\FinderFactory;
use TJVB\GitHash\Contracts\GitHashRetriever;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Values\GitHash;

final class Retriever implements GitHashRetriever
{

    private ?FinderFactory $finderFactory = null;
    public function setFinderFactory(FinderFactory $finderFactory): void
    {
        $this->finderFactory = $finderFactory;
    }

    public function getHash(string $path): GitHash
    {
        if ($this->finderFactory === null) {
            throw new GitHashException('We can\'t find a hash if we didn\'t got a finder factory');
        }
        foreach ($this->finderFactory->getRegisteredFinders() as $finder) {
            if ($finder->isAvailable()) {
                return $finder->findHash($path);
            }
        }
        throw new GitHashException('No finder available');
    }

    public static function getWithFactory(FinderFactory $finderFactory): Retriever
    {
        $retriever = new self();
        $retriever->setFinderFactory($finderFactory);
        return $retriever;
    }

    public function getHashAndIgnoreFailures(string $path): GitHash
    {
        if ($this->finderFactory === null) {
            throw new GitHashException('We can\'t find a hash if we didn\'t got a finder factory');
        }
        foreach ($this->finderFactory->getRegisteredFinders() as $finder) {
            try {
                if ($finder->isAvailable()) {
                    return $finder->findHash($path);
                }
            } catch (GitHashException) {
                // do nothing
            }
        }
        throw new GitHashException('Unable to find hash');
    }
}
