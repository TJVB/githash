<?php

declare(strict_types=1);

namespace TJVB\GitHash\Tests\HashFinders;

use org\bovigo\vfs\vfsStream;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\HashFinders\GitFileSystemHashFinder;
use TJVB\GitHash\Tests\TestCase;

final class GitFileSystemHashFinderTest extends TestCase
{
    /**
     * @test
     */
    public function weSeeThatTheFinderIsAvailable(): void
    {
        // run
        $finder = new GitFileSystemHashFinder();

        // verify/assert
        $this->assertTrue($finder->isAvailable());
    }

    /**
     * @test
     */
    public function weCanFindAHashFromTheRepositoryRoot(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        $structure['.git']['refs']['heads']['testbranch'] = ' ' . self::TEST_HASH . ' ';
        $vfStream = vfsStream::setup(structure: $structure);

        // run
        $finder = new GitFileSystemHashFinder();
        $result = $finder->findHash($vfStream->url());

        // verify/assert
        $this->assertEquals(self::TEST_HASH, $result->hash());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheDirectoryDoesntContainAGitDirectory(): void
    {
        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('Unable to find .git directory.');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash(__DIR__);
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheDirectoryIsNotPartOfAGitRepository(): void
    {
        // setup / mock
        $structure = [
            'test' => 'test',
        ];
        $vfStream = vfsStream::setup(structure: $structure);

        // verify/assert
        $this->expectException(GitHashException::class);

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheHeadFileIsMissing(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        unset($structure['.git']['HEAD']);
        $vfStream = vfsStream::setup(structure: $structure);

        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('Unable to find the HEAD in the .git directory');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheHeadFileIsNotReadable(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        unset($structure['.git']['HEAD']);
        $vfStream = vfsStream::setup(structure: $structure);
        vfsStream::newFile('.git/HEAD', 0000)->at($vfStream);

        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('Unable to read the HEAD in the .git directory');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheHeadFileIsIncorrect(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        $structure['.git']['HEAD'] = 'invallid';
        $vfStream = vfsStream::setup(structure: $structure);

        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('HEAD File isn\'t complete');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheBranchRefDoesNotExist(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        unset($structure['.git']['refs']['heads']['testbranch']);
        $vfStream = vfsStream::setup(structure: $structure);

        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('Unable to find the branch ref file.');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheBranchRefIsNotReadable(): void
    {
        // setup / mock
        $structure = $this->getFileSystemStructure();
        unset($structure['.git']['refs']['heads']['testbranch']);
        $vfStream = vfsStream::setup(structure: $structure);
        vfsStream::newFile('.git/refs/heads/testbranch', 0000)->at($vfStream);

        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('Unable to read the branch ref file.');

        // run
        $finder = new GitFileSystemHashFinder();
        $finder->findHash($vfStream->url());
    }

    private function getFileSystemStructure(): array
    {
        return [
            '.git' => [
                'HEAD' => 'ref: refs/heads/testbranch',
                'refs' => [
                    'heads' => [
                        'testbranch' => self::TEST_HASH,
                    ],
                ],
            ],
        ];
    }
}
