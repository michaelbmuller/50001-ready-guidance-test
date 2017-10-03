<?php
/**
 * This file is part of the 50001 Ready Guidance package.
 *
 * Written by Michael B Muller <muller.michaelb@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DOE_50001_Ready;

/**
 * Class Task
 * @package Guidance
 */
class Task
{
    /**
     * @var integer
     */
    var $id;
    /**
     * @var string
     */
    var $version;
    /**
     * Language Code
     * - default 'en'
     *
     * @var string
     */
    var $language = 'en';
    /**
     * Language displayed
     *  - may not be selected language if not available
     *
     * @var string
     */
    var $language_displayed;
    /**
     * Task file name
     *
     * @var string
     */
    var $task_file_name;
    /**
     * Task file contents
     *
     * @var string
     */
    protected $task_file_contents;
    /**
     * Section code
     *
     * @var string
     */
    var $sectionCode;
    /**
     * Task section name
     * - translated if selected and available
     *
     * @var string
     */
    var $section;
    /**
     * Title
     * - translated if selected and available
     *
     * @var string
     */
    var $title;
    /**
     * Menu Name
     * - translated if selected and available
     *
     * @var string
     */
    var $menuName;
    /**
     * Getting It Done
     * - translated if selected and available
     *
     * @var string
     */
    var $getting_it_done;
    /**
     * Task Overview
     *
     * @var string
     */
    var $task_overview;
    /**
     * Full Description
     *
     * @var
     */
    var $full_description;
    /**
     * Tips related to other implemented ISO management systems
     *
     * @var string
     */
    var $other_iso_tips;
    /**
     * Tips related to previous ENERGY STAR experience
     *
     * @var string
     */
    var $energyStar_tips;
    /**
     * List of prerequisite task ids
     *
     * @var array
     */
    var $prerequisites = [];

    /**
     * Load task
     *
     * @param $task_id
     * @param string $language
     * @return Task
     * @throws \Exception
     */
    static function load($task_id, $language = 'en')
    {
        if ($task_id < 1 or $task_id > 25) throw new \Exception('Task ID not valid', 404);
        $task = new self();
        $task->id = $task_id;
        $task->language = $language;

        $task->loadFile();
        return $task;
    }

    /**
     * Process and load task file data
     */
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
        $this->other_iso_tips = trim($taskPieces[14]);
        $this->energyStar_tips = trim($taskPieces[16]);
    }
}