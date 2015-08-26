<?php

    class Copy
    {
        private $book_id;
        private $due_date;
        private $id;

        function __construct($book_id, $due_date = null, $id = null)
        {
            $this->book_id = $book_id;
            $this->due_date = $due_date;
            $this->id = $id;
        }
        //Set and Get for Book
        function getBookId()
        {
            return $this->book_id;
        }
        function setBookId($new_book_id)
        {
            $this->book_id = $new_book_id;
        }

        //Set and Get for due_date
        function getDueDate()
        {
            return $this->due_date;
        }

        function setDueDate($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        //Get id
        function getId()
        {
            return $this->id;
        }
        //Save method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getBookId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

       //Update book_id
       function updateBookId($new_book_id)
       {
           $GLOBALS['DB']->exec("UPDATE copies SET book_id = {$new_book_id}
           WHERE id = {$this->getId()}");
           $this->setBookId($new_book_id);
       }

       //Update due_date
       function updateDueDate($new_due_date)
       {
           $GLOBALS['DB']->exec("UPDATE copies SET due_date = {$new_due_date}
           WHERE id = {$this->getId()}");
           $this->setDueDate($new_due_date);
       }

       //ADD/GET patron
       function addPatron($patron_id)
       {
           $GLOBALS['DB']->exec("INSERT INTO checkout (patron_id, copy_id)
           VALUES ({$patron_id}, {$this->id})");
       }

       function getPatron()
       {
           $returned_patrons = $GLOBALS['DB']->query("SELECT patrons.* FROM patrons
           JOIN checkout ON (patrons.id = checkout.patron_id) JOIN copies
           ON (copies.id = checkout.copy_id)
           WHERE copies.id = {$this->getId()}");

           $patrons = array();
           foreach ($returned_patrons as $patron) {
               $name = $patron["name"];
               $id = $patron["id"];
               $new_patron = new Patron($name, $id);
               array_push($patrons, $new_patron);
           }
           return $patrons;
       }


       /////////////////STATIC FUNCTIONS/////////////////////////


       static function getAll()
       {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();
            foreach($returned_copies as $copy) {
                $book_id = $copy["book_id"];
                $due_date = $copy["due_date"];
                $id = $copy["id"];
                $new_copy = new Copy($book_id, $due_date, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }


        //Delete All
       static function deleteAll()
       {
           $GLOBALS['DB']->exec("DELETE FROM copies");
       }

       //Find
       static function find($search_id)
       {
           $found_copy = null;
           $copies = Copy::getAll();
           foreach($copies as $copy) {
               $copy_id = $copy->getId();
               if ($copy_id == $search_id) {
                   $found_copy = $copy;
               }
           }
           return $found_copy;
       }

    }
 ?>
