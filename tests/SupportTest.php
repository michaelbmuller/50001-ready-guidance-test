<?php

namespace Tests;

use Guidance\Guidance;
use Guidance\Support;
use Guidance\Task;
use PHPUnit\Framework\TestCase;

class SupportTest extends TestCase
{
    public function test_covert_section_name()
    {
        $this->assertEquals('testTest', Support::ConvertSectionName('test test'));
    }
}