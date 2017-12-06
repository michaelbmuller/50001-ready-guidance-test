<?php

namespace DOE_50001_Ready;

class DefaultMarkupProcessor implements MarkupProcessorInterface
{
    /**
     * Return resource id as string only
     *
     * @param $resource_id
     * @return mixed
     */
    static function ResourceLink($resource_id)
    {
        return preg_filter("[_]", " ", $resource_id);
    }

    /**
     * Return Task Menu Name only
     *
     * @param $task_id_name
     * @return string
     */
    static function TaskLink($task_id_name)
    {
        return "the " . $task_id_name . " Task";
    }

    /**
     * Format Accordion tags
     *
     * @param $code
     * @param $title
     * @param $content
     * @return string
     */
    static function Accordion($code, $title, $content)
    {
        return "<h4>" . $title . "</h4>" . $content;
    }

    /**
     * Format Learn More tags
     *
     * @param $code
     * @param $title
     * @param $content
     * @return string
     */
    static function LearnMore($code, $title, $content)
    {
        return "<h4>" . $title . "</h4>" . $content;
    }


}