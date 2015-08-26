<?php

    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        //Set and Get for Name
        function getName()
        {
            return $this->name;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }

        //Get id
        function getId()
        {
            return $this->id;
        }
        //Save method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

       //Update
       function update($new_name)
       {
           $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}'
           WHERE id = {$this->getId()}");
           $this->setName($new_name);
       }


       /////////////////STATIC FUNCTIONS/////////////////////////


       static function getAll()
       {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();
            foreach($returned_authors as $author) {
                $name = $author["name"];
                $id = $author["id"];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }


        //Delete All
       static function deleteAll()
       {
           $GLOBALS['DB']->exec("DELETE FROM authors");
       }

       //Find
       static function find($search_id)
       {
           $found_author = null;
           $authors = Author::getAll();
           foreach($authors as $author) {
               $author_id = $author->getId();
               if ($author_id == $search_id) {
                   $found_author = $author;
               }
           }
           return $found_author;
       }

    }
 ?>
