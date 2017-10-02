<?php

namespace Guidance;


class Task
{

    var $id;
    var $version;
    var $language;
    var $language_displayed;
    var $task_file_name;
    var $section;
    var $title;
    var $menuName;
    var $getting_it_done;
    var $prereqs;

    static function load($task_id, $language = 'en')
    {
        if ($task_id < 1 or $task_id > 25) throw new \Exception('Task ID not valid', 404);
        $task = new self();
        $task->id = $task_id;
        $task->language = $language;

        $task->loadFile();
        return $task;
    }

    protected function loadFile()
    {
        list($this->task_file_contents, $this->language_displayed) = Support::getFile('task_' . $this->id, $this->language);
        $taskPieces = explode('----------', $this->task_file_contents);
        $this->version = explode(" ", $taskPieces[2])[0];
        $this->menuName = trim($taskPieces[4]);
        $this->title = trim($taskPieces[6]);
        $this->getting_it_done = trim($taskPieces[8]);
        $this->task_overview = trim($taskPieces[10]);
        $this->full_description = trim($taskPieces[12]);
    }
}