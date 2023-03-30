<?php

declare(strict_types=1);

namespace Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        config(['application-file' => 'application-test.yaml']);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        config(['application-file' => null]);
    }
}
