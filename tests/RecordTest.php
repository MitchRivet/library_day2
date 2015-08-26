<?php

    require_once "src/Record.php";
    require_once "src/Patron.php";
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Record.php";

        /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RecordTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Record::deleteAll();
        }

        function testGetPatronId()
        {
            //Arrange
           $patron_id = 1;
           $checkout_date = "2015-12-12";
           $copy_id = 2;
           $test_record = new Record($patron_id, $copy_id, $checkout_date);
           //Act
           $result = $test_record->getPatronId();
           //Assert
           $this->assertEquals($patron_id, $result);
        }

        function testGetCopyId()
        {
            //Arrange
           $patron_id = 1;
           $checkout_date = null;
           $copy_id = 2;
           $test_record = new Record($patron_id, $copy_id, $checkout_date);
           //Act
           $result = $test_record->getCopyId();
           //Assert
           $this->assertEquals($copy_id, $result);
        }

        function testGetCheckoutDate()
        {
            //Arrange
           $patron_id = 1;
           $checkout_date = "2015-12-12";
           $copy_id = 2;
           $test_record = new Record($patron_id, $copy_id, $checkout_date);
           //Act
           $result = $test_record->getCheckoutDate();
           //Assert
           $this->assertEquals($checkout_date, $result);
        }
        function testsave()
        {
            //Arrange
           $patron_id = 1;
           $checkout_date = "2015-02-02";
           $copy_id = 2;
           $test_record = new Record($patron_id, $copy_id, $checkout_date);
           $test_record->save();
           //Act
           $result = Record::getAll();
           //Assert
           $this->assertEquals($test_record, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
          $patron_id = 1;
          $checkout_date = "2015-02-02";
          $copy_id = 2;
          $test_record = new Record($patron_id, $copy_id, $checkout_date);
          $test_record->save();

          $patron_id2 = 1;
          $checkout_date2 = "2014-03-02";
          $copy_id2 = 2;
          $test_record2 = new Record($patron_id2, $copy_id2, $checkout_date2);
          $test_record2->save();
           //Act
           $result = Record::getAll();

           //Assert
           $this->assertEquals([$test_record, $test_record2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
          $patron_id = 1;
          $checkout_date = null;
          $copy_id = 2;
          $test_record = new Record($patron_id, $copy_id, $checkout_date);
          $test_record->save();

          $patron_id2 = 1;
          $checkout_date2 = null;
          $copy_id2 = 2;
          $test_record2 = new Record($patron_id2, $copy_id2, $checkout_date2);
          $test_record2->save();
           //Act
           Record::deleteAll();
           $result = Record::getAll();
           //Assert
           $this->assertEquals([], $result);
        }

    }
?>
