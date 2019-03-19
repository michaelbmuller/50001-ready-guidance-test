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
     * Language displayed for resource
     *
     * @var string
     */
    public $language_displayed;

    /**
     * Load resource file and return array of Resources
     *
     * @param string $language_requested
     * @return array
     * @throws \Exception
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
        $resource = null;
        foreach ($resource_file_contents as $resource_file_content) {
            $resource_details = explode(PHP_EOL, $resource_file_content);
            foreach ($resource_details as $resource_detail) {
                $data = array_map('trim',explode('||', $resource_detail));
                if (count($data) > 1) {
                    list($field, $value) =$data;
                    if ($field == 'Name') {
                        //Store last resource if present
                        if (!is_null($resource)) $resources[$resource->id] = $resource;
                        $resource = new Resource();
                        $resource->name = $value;
                        $resource->language_displayed = $language_displayed;
                    }
                    if ($field == 'ID') $resource->id = $value;
                    if ($field == 'File Type') $resource->file_type = $value;
                    if ($field == 'Short Description') $resource->short_description = $value;
                    if ($field == 'File Name') $resource->file_name = $value;
                    if ($field == 'Link') $resource->link = $value;
                    if ($field == 'Associated Tasks') {
                        $associatedTasks = array_map('trim', explode(',', trim($value)));
                        if ($associatedTasks[0]!="") $resource->associatedTasks = $associatedTasks;
                    }
                }
            }
        }
        //Add last resource
        $resources[$resource->id] = $resource;
        //usort($resources,function($a, $b){ return strcmp($a->name,$b->name); });
        return $resources;
    }

    /**
     * Return link to resource
     * - resource_directory added to local files
     *
     * @param null $resource_directory
     * @return string
     */
    public function getLink($resource_directory= null){
        if ($this->file_name) return $resource_directory."/".$this->file_name;
        return $this->link;
    }

}