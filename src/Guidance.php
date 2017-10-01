<?php

namespace Guidance;


class Guidance
{
    protected $sections = [];
    protected $tasks = [];
    protected $tasksBySection = [];

    /**
     * Guidance constructor.
     */
    public function __construct($language = 'en')
    {
        $this->language = $language;
        $this->loadTasks();
    }

    protected function loadTasks()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $task = Task::load($task_id, $this->language);
            $this->tasks[$task->id] = $task;
            $this->tasksBySection[$task->section][$task->id] = $task;
        }
        $this->loadSections();
    }

    protected function loadSections()
    {
        foreach ($this->tasksBySection as $section => $tasks) {
            $firstTaskID = key($tasks);
            $sectionTasks = count($tasks);
            $sectionKey = lcfirst(str_replace(' ', '', $section));
            $this->sections[$sectionKey] = [
                $section,
                $firstTaskID,
                $sectionTasks,
            ];
        }
    }

    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Returns array of All tasks or tasks for the given section
     *
     * @param bool $section
     * @return array
     */
    public function getTasks($section = false)
    {
        if (!$section) return $this->tasks;
        return $this->tasksBySection[$section];
    }

    public function getTask($task_id)
    {
        return $this->tasks[$task_id];
    }
}