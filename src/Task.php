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


    /**
     * Task constructor.
     */
    public function __construct($task_id, $language = 'en')
    {
        if ($task_id < 1 or $task_id > 25) throw new \Exception('Task ID not valid', 404);
        $this->id = $task_id;
        $this->language = $language;

        $this->task_file_contents = $this->getFile();
        $this->loadFile();
    }

    protected function getFile()
    {
        $task_file_name = $this->TaskFileName($this->id, $this->language);
        if (file_exists($task_file_name)){
            $this->language_displayed = $this->language;
            return file_get_contents($task_file_name);
        }

        //Default to English
        $this->language_not_found = 'true';
        $task_file_name = $this->TaskFileName($this->id, 'en');
        if (file_exists($task_file_name)) {
            $this->language_displayed = 'en';
            return file_get_contents($task_file_name);
        }

        throw new \Exception('Task File Not Found', 404);
    }

    protected function TaskFileName($task_id, $language)
    {
        return dirname(__FILE__) . "/../" . $language . '/task_' . $task_id . ".txt";
    }

    protected function loadFile(){
        $taskPieces = explode('----------',$this->task_file_contents);
        $this->version = explode(" ",$taskPieces[2])[0];
        $this->title = trim($taskPieces[4]);
        $this->menuName = trim($taskPieces[6]);
        $this->getting_it_done = $taskPieces[8];
        $this->task_overview = $taskPieces[10];
        $this->full_description = $taskPieces[12];
    }
}