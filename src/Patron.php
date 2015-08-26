<?php

    class Patron
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
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

       //Update
       function update($new_name)
       {
           $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}'
           WHERE id = {$this->getId()}");
           $this->setName($new_name);
       }

       //Add/Get Books
       function addCopy($copy_id)
       {
           $GLOBALS['DB']->exec("INSERT INTO checkout (patron_id, copy_id)
           VALUES ({$this->id}, {$copy_id})");
       }

       function getCopy()
       {
           $returned_copies = $GLOBALS['DB']->query("SELECT copies.* FROM patrons
           JOIN checkout ON (patrons.id = checkout.patron_id) JOIN copies
           ON (copies.id = checkout.copy_id)
           WHERE patrons.id = {$this->getId()}");

           $copies = array();
           foreach ($returned_copies as $copy) {
               $book_id = $copy["book_id"];
               $id = $copy["id"];
               $new_copy = new Copy($book_id, $id);
               array_push($copies, $new_copy);
           }
           return $copies;
       }


       /////////////////STATIC FUNCTIONS/////////////////////////


       static function getAll()
       {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();
            foreach($returned_patrons as $patron) {
                $name = $patron["name"];
                $id = $patron["id"];
                $new_patron = new Patron($name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }


        //Delete All
       static function deleteAll()
       {
           $GLOBALS['DB']->exec("DELETE FROM patrons");
       }

       //Find
       static function find($search_id)
       {
           $found_patron = null;
           $patrons = Patron::getAll();
           foreach($patrons as $patron) {
               $patron_id = $patron->getId();
               if ($patron_id == $search_id) {
                   $found_patron = $patron;
               }
           }
           return $found_patron;
       }



    }
 ?>
