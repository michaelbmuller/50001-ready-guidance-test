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
 * Class Guidance
 * @package Guidance
 */
class Guidance
{
    /**
     * Language code
     *
     * @var string
     */
    public $language = 'en';
    /**
     * Class name of set task markup processor
     *
     * @var string
     */
    protected $markupProcessor;
    /**
     * Array of section names with section code keys
     *
     * @var array
     */
    protected $sections_name = [];
    /**
     * Array of section details with section code keys
     *
     * @var array
     */
    protected $sections = [];
    /**
     * All tasks
     *
     * @var array
     */
    protected $tasks = [];
    /**
     * @var array
     */
    protected $taskIDsBySection = [];
    /**
     * @var array
     */
    protected $tasksBySection = [];


    public $custom_tips_added = false;

    /**
     * Guidance constructor.
     * @param string $language
     * @param string $markupProcessor
     */
    public function __construct($language = 'en', $markupProcessor = DefaultMarkupProcessor::class)
    {
        $this->language = $language;
        $this->markupProcessor = $markupProcessor;
        $this->loadTasks();
        $this->loadSections();
        $this->loadTaskStructure();
        $this->loadSectionTasks();
    }

    /**
     * Load all tasks
     */
    protected function loadTasks()
    {
        for ($task_id = 1; $task_id <= 25; $task_id++) {
            $task = Task::load($task_id, $this->language, $this->markupProcessor);
            $this->tasks[$task->id] = $task;
        }
    }

    /**
     * Load all sections
     */
    protected function loadSections()
    {
        $file_contents = explode('----------', Support::getFile('50001_ready_sections', $this->language)[0]);
        for ($sectionNumber = 1; $sectionNumber <= 4; $sectionNumber++) {
            $sectionCode = Support::ConvertSectionName($file_contents[$sectionNumber * 2 - 1]);
            $this->sections_name[$sectionCode] = trim($file_contents[$sectionNumber * 2]);
        }
    }

    /**
     * Load task structure
     *
     * @throws \Exception
     */
    protected function loadTaskStructure()
    {
        $file_contents = file_get_contents(dirname(__FILE__) . "/../guidance/task_structure.txt");
        $currentTask = null;
        foreach (explode("\r\n", $file_contents) as $row) {
            $items = explode(":", $row);
            if (count($items) < 2) continue;
            if ($items[0] == 'Section') $currentSectionCode = Support::ConvertSectionName($items[1]);
            if ($items[0] == 'Task') {
                $currentTask = (int)$items[1];
                $this->taskIDsBySection[$currentSectionCode][$currentTask] = $currentTask;
                $this->tasks[$currentTask]->sectionCode = $currentSectionCode;
                $this->tasks[$currentTask]->section = $this->sections_name[$currentSectionCode];
            }
            if ($items[0] == 'Prerequisite Tasks') {
                $prerequisites = [];
                if ($items[1]) $prerequisites = array_map('trim', explode(',', trim($items[1])));
                $this->tasks[$currentTask]->prerequisites = $prerequisites;
                foreach ($prerequisites as $prerequisite) {
                    if ($prerequisite < 1 or $prerequisite > 25) throw new \Exception('Prerequisite Task ID not valid ' . $prerequisite, 404);
                    $this->tasks[$prerequisite]->leadsTo[$currentTask] = $currentTask;
                }

            }
            if ($items[0] == 'Level of Effort') $this->tasks[$currentTask]->effort = trim($items[1]);
            if ($items[0] == 'Related ISO Sections') $this->tasks[$currentTask]->relatedIsoSections = array_map('trim', explode(',', $items[1]));
        }
    }

    /**
     * Load section specific arrays of tasks
     */
    protected function loadSectionTasks()
    {
        $this->tasksBySection = [];
        foreach ($this->taskIDsBySection as $sectionCode => $task_ids) {
            foreach ($task_ids as $task_id) $this->tasksBySection[$sectionCode][$task_id] = $this->tasks[$task_id];
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

    /**
     * Set Custom Tips on Tasks
     * - The array keys for $customTips should match the associated Task ID
     *
     * @@param array $customTips
     */
    public function setCustomTips($customTips)
    {
        foreach ($customTips as $task_id => $customTip) $this->tasks[$task_id]->custom_tips = $customTip;
        $this->custom_tips_added = true;
    }

    /**
     * Return array of sections
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Return section name
     *
     * @return array
     */
    public function getSectionName($sectionCode)
    {
        return $this->sections[$sectionCode][0];
    }

    /**
     * Returns code for previous section or dashboardCode if first section
     *
     * @param $sectionCode
     * @param $dashboardCode
     * @return string
     */
    public function previousSection($sectionCode, $dashboardCode = 'dashboard')
    {
        $previousSectionCode = $dashboardCode;
        foreach ($this->sections as $code => $sectionDetails) {
            if ($code == $sectionCode) return $previousSectionCode;
            $previousSectionCode = $code;
        }
        return $dashboardCode;
    }

    /**
     * Returns code for next section or dashboardCode if last section
     *
     * @param $sectionCode
     * @param $dashboardCode
     * @return string
     */
    public function nextSection($sectionCode, $dashboardCode = 'dashboard')
    {
        $nextSection = false;
        foreach ($this->sections as $code => $sectionDetails) {
            if ($nextSection) return $code;
            if ($code == $sectionCode) $nextSection = true;
        }
        return $dashboardCode;
    }

    /**
     * Returns array of All tasks or tasks for the given section
     *
     * @param bool|string $section
     * @return array
     */
    public function getTasks($section = false)
    {
        if (!$section) return $this->tasks;
        return $this->tasksBySection[$section];
    }

    /**
     * Return Task object
     *
     * @param $task_id
     * @return Task
     */
    public function getTask($task_id)
    {
        return $this->tasks[$task_id];
    }

    /**
     * Return first Task with Matching Menu Name
     *
     * @return string
     */
    public function getTaskByMenuName($menuName)
    {
        foreach($this->tasks as $task){
            if($task->menuName = $menuName) return $task;
        }
        return false;
    }


    /**
     * Return array of Tasks matching ISO section
     *
     * @param $iso_section
     * @return array
     */
    public function getTasksByISO($iso_section)
    {
        $matchingTasks = [];
        foreach ($this->tasks as $task) {
            if (in_array($iso_section, $task->relatedIsoSections)) $matchingTasks[] = $task;
        }
        return $matchingTasks;
    }
}