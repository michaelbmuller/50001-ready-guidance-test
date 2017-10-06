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
     * Class name of set task markup processor
     *
     * @var string
     */
    protected $markupProcessor;
    /**
     * @var integer
     */
    var $id;
    /**
     * @var string
     */
    var $version;
    /**
     * Language Code Requested
     *
     * @var string
     */
    var $language_requested;
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
    var $task_file_contents;
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
     * Optional custom tips
     * - default null
     *
     * @var string
     */
    var $custom_tips;
    /**
     * Array of associated resources
     *
     * @var
     */
    public $resources;
    /**
     * Array of prerequisite task ids
     *
     * @var array
     */
    var $prerequisites = [];
    /**
     * Array of Tasks this Task leads to
     *
     * @var array
     */
    var $leadsTo = [];
    /**
     * Array of related ISO sections
     *
     * @var array
     */
    var $relatedIsoSections = [];

    /**
     * Load task
     *
     * @param $task_id
     * @param string $language
     * @param string $markupProcessor
     * @return Task
     * @throws \Exception
     */
    static function load($task_id, $language = 'en', $markupProcessor = DefaultMarkupProcessor::class)
    {
        if ($task_id < 1 or $task_id > 25) throw new \Exception('Task ID not valid', 404);
        $task = new self();
        $task->id = $task_id;
        $task->language_requested = $language;
        $task->markupProcessor = $markupProcessor;

        $task->loadFile();
        return $task;
    }

    /**
     * Process and load task file data
     */
    protected function loadFile()
    {
        $full_id = $this->id < 10 ? '0' . $this->id : $this->id;
        list($this->task_file_contents, $this->language_displayed) = Support::getFile('50001_ready_task_' . $full_id, $this->language_requested);
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

    /**
     * Returned marked up version of Getting It Done
     *
     * @return mixed|string
     */
    public function getGettingItDone()
    {
        return Markup::process($this->getting_it_done, $this->markupProcessor);
    }

    /**
     * Returned marked up version of Task Overview
     *
     * @return mixed|string
     */
    public function getTaskOverview()
    {
        return Markup::process($this->task_overview, $this->markupProcessor);
    }

    /**
     * Returned marked up version of Full Description
     *
     * @return mixed|string
     */
    public function getFullDescription()
    {
        return Markup::process($this->full_description, $this->markupProcessor);
    }

    /**
     * Returned marked up version of Other ISO tips
     *
     * @return mixed|string
     */
    public function getOtherIsoTips()
    {
        return Markup::process($this->other_iso_tips, $this->markupProcessor);
    }

    /**
     * Returned marked up version of ENERGY STAR tips
     *
     * @return mixed|string
     */
    public function getEnergyStarTips()
    {
        return Markup::process($this->energyStar_tips, $this->markupProcessor);
    }

    /**
     * Returned marked up version of custom tips
     *
     * @return mixed|string
     */
    public function getCustomTips()
    {
        return Markup::process($this->custom_tips, $this->markupProcessor);
    }


}