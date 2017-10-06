<?php

namespace Tests;

use DOE_50001_Ready\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_task()
    {
        $task = Task::load(1);
        $this->assertEquals(1, $task->id());
        $this->assertEquals('en', $task->language_requested);
        $this->assertEquals('en', $task->language_displayed);
        $this->assertEquals("Scope and Boundaries", $task->getMenuName());
    }

    public function test_load_all_tasks()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $task = Task::load($task_id);
            $this->assertEquals($task_id, $task->id());
        }
    }

    public function test_default_to_english()
    {
        $task = Task::load(1, 'XX');
        $this->assertEquals('XX', $task->language_requested);
        $this->assertEquals('en', $task->language_displayed);
    }

    public function test_spanish()
    {
        $task = Task::load(1, 'es');
        $this->assertEquals('es', $task->language_requested);
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
}