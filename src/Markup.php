<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 10/3/2017
 * Time: 9:06 PM
 */

namespace DOE_50001_Ready;


class Markup
{
    /**
     * Regular Expression identifying resource tag
     *
     * @var string
     */
    static $RESOURCE_TAG_PATTERN = '|(\[resource\]\()[^)]+[)]|';
    /**
     * Regular Expression identifying task tag
     *
     * @var string
     */
    static $TASK_TAG_PATTERN = '|(\[task\]\()[^)]+[)]|';

    /**
     * Processes markup of current task guidance and returns updated text
     *
     * @param $text
     * @return mixed|string
     */
    static function process($text)
    {
        $text = self::addResourceLinks($text);
        $text = self::addTaskLinks($text);
        //$text = self::addExpandables($text, 'Learn More');
        //$text = self::addExpandables($text, 'Accordion');
        return $text;
    }

    /**
     * Update resource tags
     *
     * @param $text
     * @return mixed
     */
    static function addResourceLinks($text)
    {
        return preg_replace_callback(
            self::$RESOURCE_TAG_PATTERN,
            function ($matches) {
                $resource_id = substr($matches[0], 11, -1);
                return preg_filter("[_]", " ", $resource_id);
            },
            $text
        );
    }


    /**
     * Update task tags
     *
     * @param $text
     * @return mixed
     */
    static function addTaskLinks($text)
    {
        return preg_replace_callback(
            self::$TASK_TAG_PATTERN,
            function ($matches) {
                $task_menu_name = trim(substr($matches[0], 7, -1));
                return $task_menu_name . " Task";
            },
            $text
        );
    }

    /**
     * Update expandable elements tags
     * - Accordion
     * - Learn More
     *
     * @param $text
     * @return string
     */
    static function addExpandables($text, $triggerText)
    {
        $pieces = explode("<p>[{$triggerText}]", $text);
        for ($x = 1; $x <= count($pieces) - 1; $x++) {
            $sub_pieces = explode("<p>[{$triggerText} End]</p>", $pieces[$x]);
            $sub_pieces[0] = substr(trim($sub_pieces[0]), 1);
            $regularContent = $sub_pieces[1];
            $sub_sub_pieces = explode(")</p>", $sub_pieces[0]);
            $title = $sub_sub_pieces[0];
            unset($sub_sub_pieces[0]);
            $content = implode(')', $sub_sub_pieces);

            $updatedContent = "<h4>".$title."</h4>". $content;

            $pieces[$x] = $updatedContent . $regularContent;
        }
        $markup = implode("", $pieces);

        return $markup;
    }
}