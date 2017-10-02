<?php

namespace Guidance;


class Task
{

    var $id;
    var $version;
    var $language;
    var $language_displayed;
    var $task_file_name;
    var $title;
    var $menuName;
    var $getting_it_done;

    static function load($task_id, $language = 'en')
    {
        if ($task_id < 1 or $task_id > 25) throw new \Exception('Task ID not valid', 404);
        $task = new self();
        $task->id = $task_id;
        $task->language = $language;

        list($task->task_file_contents,$task->language_displayed) = Support::getFile('task_'.$task_id,$language);
        $task->loadFile();
        return $task;
    }

    protected function loadFile(){
        $taskPieces = explode('----------',$this->task_file_contents);
        $this->version = explode(" ",$taskPieces[2])[0];
        $this->section = trim($taskPieces[4]);
        $this->menuName = trim($taskPieces[6]);
        $this->title = trim($taskPieces[8]);
        $this->getting_it_done = $taskPieces[10];
        $this->task_overview = $taskPieces[12];
        $this->full_description = $taskPieces[14];
    }
}