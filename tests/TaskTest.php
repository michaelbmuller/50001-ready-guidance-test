<?php

namespace Tests;

use Guidance\Guidance;
use Guidance\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{

    public function test_task()
    {
        $task = Task::load(1);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('en', $task->language);
        $this->assertEquals('en', $task->language_displayed);
        $this->assertEquals("Scope and Boundaries", $task->menuName);
    }

    public function test_load_all_tasks()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $task = Task::load($task_id);
            $this->assertEquals($task_id, $task->id);
        }
    }

    public function test_default_to_english()
    {
        $task = Task::load(1, 'XX');
        $this->assertEquals('XX', $task->language);
        $this->assertEquals('en', $task->language_displayed);
    }

    public function test_spanish()
    {
        $task = Task::load(1, 'es');
        $this->assertEquals('es', $task->language);
        $this->assertEquals('es', $task->language_displayed);
    }

    public function test_missing_task()
    {
        $this->expectExceptionMessage('Task ID not valid');
        Task::load(0);
    }

    public function test_missing_task2()
    {
        $this->expectExceptionMessage('Task ID not valid');
        Task::load(26);
    }

    public function test_tasks()
    {
        $guidance = new Guidance();
        foreach ($guidance->getTasks() as $task_id => $task) {
            $this->assertEquals($task_id, $task->id);
        }

        foreach ($guidance->getTasks('Planning') as $task_id => $task) {
            $this->assertEquals($task_id, $task->id);
        }
    }

    public function test_getTask()
    {
        $guidance = new Guidance();
        $task = $guidance->getTask(1);

        $this->assertEquals(1, $task->id);
    }

    public function test_sections()
    {
        $guidance = new Guidance();
        $sections = $guidance->getSections();
        $currentSections = [
            'planning' => ['Planning', 1, 5],
            'energyReview' => ['Energy Review', 6, 8],
            'continualImprovement' => ['Continual Improvement', 14, 5],
            'systemManagement' => ['System Management', 19, 7],
        ];

        $this->assertEquals($currentSections,$sections);
    }


}