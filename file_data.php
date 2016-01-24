<?php
class FileData
{
    public $title;
    public $path;

    public function __construct($title, $path)
    {
        $this->title = $title;
        $this->path = $path;
    }
}
