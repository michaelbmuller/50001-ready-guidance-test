<?php

namespace Guidance;


class Guidance
{
    private $tasks = [];

    /**
     * Guidance constructor.
     */
    public function __construct()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $this->tasks[$task_id] = new Task($task_id);
        }
    }

    static function Tasks()
    {
        $tasks = [];
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $tasks[$task_id] = new Task($task_id);
        }
        return $tasks;
    }
}