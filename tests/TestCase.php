<?php

namespace Tests;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    protected $defaultData;
    use CreatesApplication;
}
