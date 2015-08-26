<?php

    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }
        //Set and Get for Title
        function getTitle()
        {
            return $this->title;
        }
        function setTitle($newTitle)
        {
            $this->title = $new_title;
        }

        //Get id
        function getId()
        {
            return $this->id;
        }
    }
 ?>
