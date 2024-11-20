<?php

declare(strict_types=1);

namespace TJVB\GitHash\Tests\Retrievers;

use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Factories\GitHashFinderFactory;
use TJVB\GitHash\Retrievers\Retriever;
use TJVB\GitHash\Tests\Fixtures\GitHashFinderFixture;
use TJVB\GitHash\Tests\TestCase;
use TJVB\GitHash\Values\GitHash;

final class RetrieverTest extends TestCase
{
    /**
     * @test
     */
    public function byDefaultWeDontHaveAFinderFactory(): void
    {
        // run
        $retriever = new Retriever();

        // verify/assert
        $this->assertNull($retriever->getFinderFactory());
    }

    /**
     * @test
     */
    public function weCanSetTheFinderFactory(): void
    {
        // setup / mock
        $factory = new GitHashFinderFactory();

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        // verify/assert
        $this->assertEquals($factory, $retriever->getFinderFactory());
    }

    /**
     * @test
     *
     * @dataProvider hashMethodsProvider
     */
    public function weCanNotGetAHashWithoutAFinderFactory(string $method): void
    {
        // verify/assert
        $this->expectException(GitHashException::class);
        $this->expectExceptionMessage('We can\'t find a hash if we didn\'t got a finder factory');

        // run
        $retriever = new Retriever();
        $retriever->$method(self::PROJECT_ROOT);
    }

    /**
     * @test
     *
     * @dataProvider hashMethodsProvider
     */
    public function weCanGetTheHashIfWeHaveAnAvailableFinder(string $method): void
    {
        // setup / mock
        $gitHash = new GitHash(sha1('test' . rand()));
        $finder = new GitHashFinderFixture();
        $finder->gitHash = $gitHash;

        $factory = new GitHashFinderFactory();
        $factory->register($finder);

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        $result = $retriever->$method(self::PROJECT_ROOT);

        // verify/assert
        $this->assertEquals($gitHash, $result);
    }

    /**
     * @test
     *
     * @dataProvider hashMethodsProvider
     */
    public function weGetAnExceptionIfNoneOfTheFindersIsAvailable(string $method): void
    {
        // setup / mock
        $finder = new GitHashFinderFixture();
        $finder->available = false;

        // verify/assert
        $this->expectException(GitHashException::class);
        if ($method === 'getHash') {
            $this->expectExceptionMessage('No finder available');
        }
        if ($method === 'GitHashException') {
            $this->expectExceptionMessage('Unable to find hash');
        }

        // run
        $factory = new GitHashFinderFactory();
        $factory->register($finder);

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        $retriever->$method(self::PROJECT_ROOT);
    }

    /**
     * @test
     *
     * @dataProvider hashMethodsProvider
     */
    public function weGetTheHashIfThereAreFindersAvailableWhileOthersAreNotAvailable(string $method): void
    {
        // setup / mock
        $gitHash = new GitHash(sha1('test' . rand()));
        $finder1 = new GitHashFinderFixture();
        $finder1->available = false;
        $finder2 = new GitHashFinderFixture();
        $finder2->gitHash = $gitHash;

        $factory = new GitHashFinderFactory();
        $factory->register($finder1);
        $factory->register($finder2);

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        $result = $retriever->$method(self::PROJECT_ROOT);

        // verify/assert
        $this->assertEquals($gitHash, $result);
    }

    /**
     * @test
     */
    public function weGetAnExceptionIfAFinderThrowsAnExceptionBeforeWeHaveTheHash(): void
    {
        // setup / mock
        $exception = new GitHashException('test exception');

        $gitHash = new GitHash(sha1('test' . rand()));
        $finder1 = new GitHashFinderFixture();
        $finder1->exception = $exception;

        $finder2 = new GitHashFinderFixture();
        $finder2->gitHash = $gitHash;

        $factory = new GitHashFinderFactory();
        $factory->register($finder1);
        $factory->register($finder2);

        // verify/assert
        $this->expectExceptionObject($exception);

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        $retriever->getHash(self::PROJECT_ROOT);
    }

    /**
     * @test
     */
    public function weDontGetAnExceptionIfAFinderThrowsAnExceptionBeforeWeHaveTheHashAndIgnoreFailures(): void
    {
        // setup / mock
        $exception = new GitHashException('test exception');

        $gitHash = new GitHash(sha1('test' . rand()));
        $finder1 = new GitHashFinderFixture();
        $finder1->exception = $exception;

        $finder2 = new GitHashFinderFixture();
        $finder2->gitHash = $gitHash;

        $factory = new GitHashFinderFactory();
        $factory->register($finder1);
        $factory->register($finder2);

        // run
        $retriever = new Retriever();
        $retriever->setFinderFactory($factory);

        $result = $retriever->getHashAndIgnoreFailures(self::PROJECT_ROOT);

        // verify/assert
        $this->assertEquals($gitHash, $result);
    }

    /**
     * @test
     */
    public function weGetTheRetrieverWithTheFactoryIfWeInstantiateWithIt(): void
    {
        // setup / mock
        $factory = new GitHashFinderFactory();

        // run
        $retriever = Retriever::getWithFactory($factory);

        // verify/assert
        $this->assertEquals($factory, $retriever->getFinderFactory());
    }

    public static function hashMethodsProvider(): array
    {
        return [
            'with failures' => ['getHash'],
            'ignore failures' => ['getHashAndIgnoreFailures'],
        ];
    }
}
