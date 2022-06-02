<?php

declare(strict_types=1);

namespace Tjvb\GitHash\Tests\Values;

use Faker\Factory;
use TJVB\GitHash\Tests\TestCase;
use TJVB\GitHash\Values\GitHash;

class GitHashTest extends TestCase
{
    /**
     * @test
     */
    public function weGetTheProvidedHash(): void
    {
        // setup / mock
        $faker = Factory::create();
        $hash = $faker->sha1();

        // run
        $gitHash = new GitHash($hash);

        // verify/assert
        $this->assertEquals($hash, $gitHash->hash());
    }

    /**
     * @test
     */
    public function weGetAShortForTheWantedLength(): void
    {
        // setup / mock
        $faker = Factory::create();
        $hash = $faker->sha1();
        $size = mt_rand(6, 39);

        // run
        $gitHash = new GitHash($hash);
        $short = $gitHash->short($size);

        // verify/assert
        $this->assertSame(strlen($short), $size);
        $this->assertStringContainsString($short, $hash);
    }

    /**
     * @test
     */
    public function weStripTheNewLinesFromTheHash(): void
    {
        // setup / mock
        $faker = Factory::create();
        $hash = $faker->sha1();

        // run
        $gitHash = new GitHash($hash . "\n");

        // verify/assert
        $this->assertEquals($hash, $gitHash->hash());
    }
}
