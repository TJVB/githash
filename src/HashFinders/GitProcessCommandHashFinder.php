<?php

declare(strict_types=1);

namespace TJVB\GitHash\HashFinders;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use TJVB\GitHash\Contracts\GitHashFinder;
use TJVB\GitHash\Exceptions\FindHashException;
use TJVB\GitHash\Values\GitHash;

final class GitProcessCommandHashFinder implements GitHashFinder
{
    /**
     * @inheritDoc
     */
    public function findHash(string $path): GitHash
    {
        $command = 'git rev-parse HEAD';
        try {
            $process = Process::fromShellCommandline($command, $path);
            $process->mustRun();
            $output = $process->getOutput();
            return new GitHash($output);
        } catch (ProcessFailedException) {
            throw new FindHashException('Failed to execute git command');
        }
    }

    public function isAvailable(): bool
    {
        return class_exists('Symfony\Component\Process\Process') &&
            method_exists(Process::class, 'fromShellCommandline')
        ;
    }
}
