<?php

declare(strict_types=1);

namespace TJVB\GitHash\HashFinders;

use Exception;
use TJVB\GitHash\Contracts\GitHashFinder;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Values\GitHash;

final class GitFileSystemHashFinder implements GitHashFinder
{

    public const GIT_DIRECTORY = '.git';
    public const HEAD_FILE = 'HEAD';

    /**
     * @inheritDoc
     */
    public function findHash(string $path): GitHash
    {
        if (substr($path, -1) !== DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        if (!is_dir($path . self::GIT_DIRECTORY)) {
            throw new GitHashException('Unable to find ' . self::GIT_DIRECTORY . ' directory.');
        }
        $headContent = $this->getHeadContent($path);

        $branchRefContent = $this->getBranchRefContentFromHeadContent($headContent, $path);

        return new GitHash(trim($branchRefContent));
    }

    public function isAvailable(): bool
    {
        return true;
    }

    /**
     * @throws GitHashException
     */
    private function getHeadContent(string $path): string
    {
        $headPath = $path . self::GIT_DIRECTORY . DIRECTORY_SEPARATOR . self::HEAD_FILE;
        if (!is_file($headPath)) {
            throw new GitHashException(
                'Unable to find the ' . self::HEAD_FILE . ' in the ' . self::GIT_DIRECTORY . ' directory'
            );
        }
        if (!is_readable($headPath)) {
            throw new GitHashException(
                'Unable to read the ' . self::HEAD_FILE . ' in the ' . self::GIT_DIRECTORY . ' directory'
            );
        }
        $headContent = file_get_contents($headPath);
        if ($headContent === false) {
            throw new GitHashException(
                'Unable to read the ' . self::HEAD_FILE . ' in the ' . self::GIT_DIRECTORY . ' directory'
            );
        }
        return $headContent;
    }

    /**
     * @throws GitHashException
     */
    private function getBranchRefContentFromHeadContent(string $headContent, string $path): string
    {
        $headContentParts = explode(':', $headContent, 2);
        if (!isset($headContentParts[1])) {
            throw new GitHashException(
                'HEAD File isn\'t complete'
            );
        }
        $branchRefPath = $path . self::GIT_DIRECTORY . DIRECTORY_SEPARATOR . trim($headContentParts[1]);
        if (!is_file($branchRefPath)) {
            throw new GitHashException(
                'Unable to find the branch ref file.'
            );
        }
        if (!is_readable($branchRefPath)) {
            throw new GitHashException(
                'Unable to read the branch ref file.'
            );
        }
        $branchRefContent = file_get_contents($branchRefPath);
        if ($branchRefContent === false) {
            throw new GitHashException(
                'Unable to read the branch ref file.'
            );
        }
        return $branchRefContent;
    }
}
