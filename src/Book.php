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
        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        //Get id
        function getId()
        {
            return $this->id;
        }
        //Save method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books");
            $books = array();
            foreach($returned_books as $book) {
                $title = $book["title"];
                $id = $book["id"];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }
        //Delete All
       static function deleteAll()
       {
           $GLOBALS['DB']->exec("DELETE FROM books");
       }
       //Update
       function update($new_title)
       {
           $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}'
           WHERE id = {$this->getId()}");
           $this->setTitle($new_title);
       }

    }
 ?>
