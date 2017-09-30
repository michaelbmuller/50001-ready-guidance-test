<?php

namespace Tests;

use Guidance\Task;
use PHPUnit\Framework\TestCase;
use Prophecy\Exception\Exception;

class TaskTest extends TestCase
{

    public function test_task()
    {
        $task = new Task(1);
        $this->assertEquals(1,$task->id);
        $this->assertEquals('en',$task->language);
        $this->assertEquals('en',$task->language_displayed);
        $this->assertEquals("Scope and Boundaries",$task->title);
    }

    public function test_load_all_tasks()
    {
        for($task_id=1;$task_id<=25;$task_id++){
            $task = new Task($task_id);
            $this->assertEquals($task_id,$task->id);
        }
    }

    public function test_default_to_english()
    {
        $task = new Task(1,'XX');
        $this->assertEquals('XX',$task->language);
        $this->assertEquals('en',$task->language_displayed);
    }

    public function test_missing_task()
    {
        $this->setExpectedException('Exception','Task ID not valid');
        new Task(0);
    }

    public function test_missing_task2()
    {
        $this->setExpectedException('Exception','Task ID not valid');
        new Task(26);
    }




}