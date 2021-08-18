<?php

declare(strict_types=1);

namespace TJVB\GitHash\HashFinders;

use TJVB\GitHash\Contracts\GitHashFinder;
use TJVB\GitHash\Exceptions\FindHashException;
use TJVB\GitHash\Values\GitHash;

final class GitShellExecCommandHashFinder implements GitHashFinder
{
    /**
     * @inheritDoc
     */
    public function findHash(string $path): GitHash
    {
        if (substr($path, -1) !== DIRECTORY_SEPARATOR) {
            $path = $path . DIRECTORY_SEPARATOR;
        }
        $command = 'git --git-dir=' . $path . '.git --work-tree=' . $path . ' rev-parse HEAD';
        $output = shell_exec($command);
        if (!is_string($output)) {
            throw new FindHashException('Failed to execute git command');
        }
        return new GitHash($output);
    }

    public function isAvailable(): bool
    {
        if (!function_exists('shell_exec')) {
            return false;
        }
        // shell_exec is a function that is more then once disabled on system.
        $disabled = explode(',', ini_get('disable_functions'));
        return !in_array('shell_exec', $disabled);
    }
}
