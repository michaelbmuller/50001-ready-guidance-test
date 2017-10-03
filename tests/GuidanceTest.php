<?php

namespace Tests;

use DOE_50001_Ready\Guidance;
use DOE_50001_Ready\Task;
use PHPUnit\Framework\TestCase;

class GuidanceTest extends TestCase
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

    public function test_alternate_language()
    {
        $guidance = new Guidance('es');
        $this->assertEquals('es', $guidance->language);
        $this->assertEquals('es', $guidance->getTask(1)->language_displayed);
    }

    public function test_guidance_get_all_tasks()
    {
        foreach ($this->guidance->getTasks() as $task_id => $task) {
            $this->assertInstanceOf(Task::class, $task);
            $this->assertEquals($task_id, $task->id);
        }
    }

    public function test_guidance_get_section_tasks()
    {
        foreach ($this->guidance->getTasks('planning') as $task_id => $task) {
            $this->assertInstanceOf(Task::class, $task);
            $this->assertEquals($task_id, $task->id);
            $this->assertEquals('Planning', $task->section);
        }
    }

    public function test_get_task()
    {
        $this->assertEquals(1, $this->guidance->getTask(1)->id);
    }

    public function test_sections()
    {
        $currentSections = [
            'planning' => ['Planning', 1, 5],
            'energyReview' => ['Energy Review', 6, 8],
            'continualImprovement' => ['Continual Improvement', 14, 5],
            'systemManagement' => ['System Management', 19, 7],
        ];
        $this->assertEquals($currentSections, $this->guidance->getSections());
    }
}