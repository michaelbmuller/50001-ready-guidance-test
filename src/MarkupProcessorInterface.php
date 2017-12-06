<?php
/**
 * This file is part of the 50001 Ready Guidance package.
 *
 * Copyright Michael B Muller, 2017
 *
 * Initially written by Michael B Muller <muller.michaelb@gmail.com>
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
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
     * @param $task_id_name
     * @return string
     */
    static function TaskLink($task_id_name);

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