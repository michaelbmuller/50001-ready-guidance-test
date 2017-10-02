<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 10/1/2017
 * Time: 9:05 PM
 */

namespace Guidance;


class Support
{
    static function getFile($file_name, $language = 'en')
    {
        $file_contents = false;
        $language_displayed = false;

        $full_file_name = self::setFileName($file_name, $language);
        if (file_exists($full_file_name)) {
            $language_displayed = $language;
            $file_contents = file_get_contents($full_file_name);
        }

        //Default to English
        $full_file_name = self::setFileName($file_name, 'en');
        if (file_exists($full_file_name)) {
            $language_displayed = 'en';
            $file_contents = file_get_contents($full_file_name);
        }

        if (!$file_contents) throw new \Exception('Task File Not Found', 404);

        return [
            $file_contents,
            $language_displayed
        ];
    }

    static function setFileName($file_name, $language)
    {
        return dirname(__FILE__) . "/../guidance/" . $language . '/' . $file_name . ".txt";
    }
}