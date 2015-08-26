<?php

    class Copy
    {
        private $book_id;
        private $id;

        function __construct($book_id, $id = null)
        {
            $this->book_id = $book_id;
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

        //Get id
        function getId()
        {
            return $this->id;
        }
        //Save method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ('{$this->getBookId()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

       //Update
       function update($new_book_id)
       {
           $GLOBALS['DB']->exec("UPDATE copies SET book_id = '{$new_book_id}'
           WHERE id = {$this->getId()}");
           $this->setBookId($new_book_id);
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
                $id = $copy["id"];
                $new_copy = new Copy($book_id, $id);
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
