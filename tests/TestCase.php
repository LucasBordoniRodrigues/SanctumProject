<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public Generator $faker;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
    }
}
