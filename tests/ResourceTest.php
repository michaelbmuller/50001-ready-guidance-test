<?php

namespace Tests;

use DOE_50001_Ready\Guidance;
use DOE_50001_Ready\Resource;
use DOE_50001_Ready\Task;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    /**
     * @var Guidance
     */
    protected $guidance;

    /**
     * GuidanceTest constructor.
     */
    public function setUp()
    {
        $this->guidance = new Guidance();
    }

    public function test_load_resources()
    {
        $this->assertGreaterThan(0,count($this->guidance->resources));
    }

    public function test_task_resources(){
        $this->assertGreaterThan(0,count($this->guidance->getTask(1)->resources));
    }

    public function test_get_link(){
        $this->assertEquals('Directory/Business Drivers and the EnMS Resource Sheet.docx',
            $this->guidance->resources['Business_Drivers_EnMS']->getLink('Directory'));
        $this->assertEquals('http://www1.eere.energy.gov/apps/manufacturing/eguide/Level2/L2%20SAdoc_Energy%20Manual%20Guidelines.pdf',
            $this->guidance->resources['Energy_Manual_Guidelines']->getLink('Directory'));

    }


}