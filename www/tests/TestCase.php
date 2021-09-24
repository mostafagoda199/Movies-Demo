<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public const UNAUTHORIZED_STATUS = 401;
    public const FAIL_VALIDATION_STATUS = 422;
    public const POST_METHOD = 'post';
    public const GET_METHOD = 'get';
}
