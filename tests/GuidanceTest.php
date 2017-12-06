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
            $this->assertEquals($task_id, $task->id());
        }
    }

    public function test_guidance_get_section_tasks()
    {
        foreach ($this->guidance->getTasks('planning') as $task_id => $task) {
            $this->assertInstanceOf(Task::class, $task);
            $this->assertEquals($task_id, $task->id());
            $this->assertEquals('Planning', $task->section);
        }
    }

    public function test_get_task()
    {
        $this->assertEquals(1, $this->guidance->getTask(1)->id());
    }

    public function test_task_by_id_name()
    {
        $this->assertEquals('1', $this->guidance->getTaskByIDName('Scope and Boundaries')->id());
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

    public function test_section_name()
    {
        $this->assertEquals('Planning', $this->guidance->getSectionName('planning'));
    }

    public function test_previous_section()
    {
        $previousSection = $this->guidance->previousSection('planning');
        $this->assertEquals('dashboard', $previousSection);
        $previousSection = $this->guidance->previousSection('energyReview');
        $this->assertEquals('planning', $previousSection);
    }

    public function test_next_section()
    {
        $previousSection = $this->guidance->nextSection('planning');
        $this->assertEquals('energyReview', $previousSection);
        $previousSection = $this->guidance->nextSection('systemManagement');
        $this->assertEquals('dashboard', $previousSection);
    }

    public function test_iso_sections()
    {
        $tasks = $this->guidance->getTasksByISO('4.7');
        $this->assertEquals(25, $tasks[0]->id());
    }

    public function test_task_leads_to()
    {
        $this->assertEquals([6 => 6, 9 => 9], $this->guidance->getTask(1)->leadsTo);
    }

    public function test_set_custom_tips()
    {
        $this->guidance->setCustomTips([
            1 => 'Something Useful',
            5 => 'Something Else Useful'
        ]);
        $this->assertTrue($this->guidance->custom_tips_added);
        $this->assertEquals('Something Useful', $this->guidance->getTask(1)->custom_tips);
        $this->assertEquals('Something Else Useful', $this->guidance->getTask(5)->custom_tips);
    }
}