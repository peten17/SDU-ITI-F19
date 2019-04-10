<?php

class Post
{
    public $id;
    public $owner;
    public $file_name;
    public $uploaded_on;
    public $title;
    public $description;

    /**
     * Post constructor.
     * @param $id
     * @param $owner
     * @param $file_name
     * @param $uploaded_on
     * @param $title
     * @param $description
     */
    public function __construct($id, $owner, $file_name, $uploaded_on, $title, $description)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->file_name = $file_name;
        $this->uploaded_on = $uploaded_on;
        $this->title = $title;
        $this->description = $description;
    }

    protected function fill($row) {

    }

}
