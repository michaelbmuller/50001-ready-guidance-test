<?php

namespace DOE_50001_Ready;


class Resource
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * File type extension code
     *
     * @var string
     */
    public $file_type;
    /**
     * @var string
     */
    public $short_description;
    /**
     * File name for local resources
     *
     * @var string
     */
    public $file_name;
    /**
     * Link for external resources
     *
     * @var string
     */
    public $link;
    /**
     * Array of associated Task IDs
     *
     * @var array
     */
    public $associatedTasks = [];

    /**
     * Load resource file and return array of Resources
     *
     * @param string $language_requested
     * @return array
     */
    static function load($language_requested = 'en')
    {
        $resources = [];
        list($resource_file_contents, $language_displayed) = Support::getFile('50001_ready_resources', $language_requested);
        $resource_file_contents = explode('----------', $resource_file_contents);
        //Removed added content
        array_shift($resource_file_contents);
        array_shift($resource_file_contents);
        array_pop($resource_file_contents);
        array_pop($resource_file_contents);
        foreach ($resource_file_contents as $resource_file_content) {
            $resource_details = explode(PHP_EOL, $resource_file_content);
            $resource = null;
            foreach ($resource_details as $resource_detail) {
                $data = explode('::', $resource_detail);
                if (count($data) > 1) {
                    list($field, $value) =$data;
                    if ($field == 'Name') {
                        $resource = new Resource();
                        $resource->name = $value;
                    }
                    if ($field == 'ID') $resource->id = $value;
                    if ($field == 'File Type') $resource->file_type = $value;
                    if ($field == 'Short Description') $resource->short_description = $value;
                    if ($field == 'File Name') $resource->file_name = $value;
                    if ($field == 'Link') $resource->link = $value;
                    if ($field == 'Associated Tasks') {
                        $resource->associatedTasks = array_map('trim', explode(',', trim($value)));
                        $resources[] = $resource;
                    }
                }
            }

        }
        return $resources;
    }
}