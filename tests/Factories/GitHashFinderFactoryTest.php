<?php

declare(strict_types=1);

namespace TJVB\GitHash\Tests\Factories;

use TJVB\GitHash\Factories\GitHashFinderFactory;
use TJVB\GitHash\Tests\Fixtures\GitHashFinderFixture;
use TJVB\GitHash\Tests\TestCase;

class GitHashFinderFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function theFactoryDoesNotHaveAnyFinderByDefault(): void
    {
        // setup / mock

        // run
        $factory = new GitHashFinderFactory();
        $finders = $factory->getRegisteredFinders();

        // verify/assert
        $this->assertEmpty($finders);
    }

    /**
     * @test
     */
    public function weCanRegisterAFinder(): void
    {
        // setup / mock
        $finder = new GitHashFinderFixture();

        // run
        $factory = new GitHashFinderFactory();
        $factory->register($finder);

        $result = $factory->getRegisteredFinders();

        // verify/assert
        $this->assertCount(1, $result);
        $this->assertContains($finder, $result);
    }

    /**
     * @test
     */
    public function weCanRegisterDefaultFindersOnAFactory(): void
    {
        // setup / mock

        // run
        $factory = new GitHashFinderFactory();
        $factory->registerDefaultFinders();
        $finders = $factory->getRegisteredFinders();

        // verify/assert
        $this->assertNotEmpty($finders);
    }

    /**
     * @test
     */
    public function weCanInstantiateWithTheDefaultFinders(): void
    {
        // setup / mock

        // run
        $factory = GitHashFinderFactory::withDefaultFinders();
        $finders = $factory->getRegisteredFinders();

        // verify/assert
        $this->assertNotEmpty($finders);
    }
}
