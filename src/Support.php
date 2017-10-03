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
 * Class Support
 * @package Guidance
 */
class Support
{
    /**
     * Retrieve the selected file
     * - Initially tries selected language code
     * - Default to 'en' language code if matching selected language file not found
     *
     * @param $file_name
     * @param string $language
     * @return array
     * @throws \Exception
     */
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

    /**
     * Return full file path based on file name and selected language code
     *
     * @param $file_name
     * @param $language
     * @return string
     */
    static function setFileName($file_name, $language)
    {
        return dirname(__FILE__) . "/../guidance/" . $language . '/' . $file_name . ".txt";
    }

    /**
     * Converts name to camelcase code
     *
     * @param $name
     * @return string
     */
    static function ConvertSectionName($name){
        return lcfirst(str_replace(' ', '', ucwords(trim($name))));
    }
}