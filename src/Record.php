<?php


    class Record
    {
        private $patron_id;
        private $copy_id;
        private $checkout_date;
        private $id;


        function __construct($patron_id, $copy_id, $checkout_date, $id = null)
        {
            $this->patron_id = $patron_id;
            $this->copy_id = $copy_id;
            $this->checkout_date = $checkout_date;
            $this->id = $id;
        }

        //Set and Get for patron_id
        function getPatronId()
        {
            return $this->patron_id;
        }

        function setPatronId($new_patron_id)
        {
            $this->patron_id = $new_patron_id;
        }

        //Set and Get for copy_id
        function getCopyId()
        {
            return $this->copy_id;
        }

        function setCopyId($new_copy_id)
        {
            $this->copy_id = $new_copy_id;
        }

        //Set and Get for checkout_date
        function getCheckoutDate()
        {
            return $this->checkout_date;
        }
        function setCheckoutDate($new_checkout_date)
        {
            $this->checkout_date = $new_checkout_date;
        }
        function getRecordId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO records (patron_id, copy_id, checkout_date)
             VALUES ({$this->getPatronId()}, {$this->getCopyId()}, '{$this->getCheckoutDate()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
             $returned_records = $GLOBALS['DB']->query("SELECT * FROM records");
             $records = array();
             foreach($returned_records as $record) {
                 $patron_id = $record["patron_id"];
                 $copy_id = $record["copy_id"];
                 $checkout_date = $record["checkout_date"];
                 $id = $record["id"];
                 $new_record = new Record($patron_id, $copy_id, $checkout_date, $id);
                 array_push($records, $new_record);
             }
             return $records;
         }


         //Delete All
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM records");
        }
    }



 ?>
