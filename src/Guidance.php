<?php

namespace Guidance;


class Guidance
{
    protected $sections_name = [];
    protected $sections = [];
    protected $tasks = [];
    protected $taskIDsBySection = [];
    protected $tasksBySection = [];

    /**
     * Guidance constructor.
     */
    public function __construct($language = 'en')
    {
        $this->language = $language;
        $this->loadTasks();
        $this->loadSections();
        $this->loadTaskStructure();
        $this->loadSectionTasks();
    }

    protected function loadTasks()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $task = Task::load($task_id, $this->language);
            $this->tasks[$task->id] = $task;
        }
    }

    protected function loadSections(){
        $file_contents = explode('----------',Support::getFile('sections',$this->language)[0]);
        for($sectionNumber = 1; $sectionNumber<=4;$sectionNumber++){
            $sectionCode = Support::ConvertSectionName($file_contents[$sectionNumber*2-1]);
            $this->sections_name[$sectionCode] = trim($file_contents[$sectionNumber*2]);
        }
    }

    protected function loadTaskStructure(){
        $file_contents = file_get_contents(dirname(__FILE__) . "/../guidance/task_structure.txt");
        foreach(explode("\r\n",$file_contents) as $row){
            $items = explode(":",$row);
            if(count($items)<2) continue;
            if ($items[0]=='Section') $currentSectionCode = Support::ConvertSectionName($items[1]);
            if ($items[0]=='Task') {
                $currentTask = (int)$items[1];
                $this->taskIDsBySection[$currentSectionCode][$currentTask] = $currentTask;
                $this->tasks[$currentTask]->section = $this->sections_name[$currentSectionCode];
            }
            if ($items[0]=='Prerequisite Tasks') $this->tasks[$currentTask]->prereqs = explode(',',trim($items[1]));
            if ($items[0]=='Level of Effort') $this->tasks[$currentTask]->effort = trim($items[1]);
        }
    }

    protected function loadSectionTasks()
    {
        $this->tasksBySection = [];
        foreach($this->taskIDsBySection as $sectionCode => $task_ids){
            foreach($task_ids as $task_id) $this->tasksBySection[$sectionCode][$task_id] = $this->tasks[$task_id];
        }
        foreach ($this->tasksBySection as $section => $tasks) {
            $firstTaskID = key($tasks);
            $sectionTasks = count($tasks);
            $sectionKey = $section;
            $this->sections[$sectionKey] = [
                $this->sections_name[$sectionKey],
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