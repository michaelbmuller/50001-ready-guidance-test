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
        $full_file_name = self::setFileName($file_name, $language);
        if (file_exists($full_file_name)) {
            return [
                file_get_contents($full_file_name),
                $language
            ];
        }

        //Default to English
        $full_file_name = self::setFileName($file_name, 'en');
        if (file_exists($full_file_name)) {
            return [
                file_get_contents($full_file_name),
                'en'
            ];
        }

        throw new \Exception('Task File Not Found', 404);
    }

    static function setFileName($file_name, $language)
    {
        return dirname(__FILE__) . "/../guidance/" . $language . '/' . $file_name . ".txt";
    }

    static function ConvertSectionName($name){
        return lcfirst(str_replace(' ', '', ucwords(trim($name))));
    }
}