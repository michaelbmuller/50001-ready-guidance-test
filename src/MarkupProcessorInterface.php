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

interface MarkupProcessorInterface
{
    /**
     * Return resource id as string only
     *
     * @param $resource_id
     * @return mixed
     */
    static function ResourceLink($resource_id);

    /**
     * Return Task Menu Name only
     *
     * @param $task_menu_name
     * @return string
     */
    static function TaskLink($task_menu_name);

    /**
     * Format Accordion tags
     *
     * @param $code
     * @param $title
     * @param $content
     * @return string
     */
    static function Accordion($code, $title, $content);

    /**
     * Format Learn More tags
     *
     * @param $code
     * @param $title
     * @param $content
     * @return string
     */
    static function LearnMore($code, $title, $content);
}