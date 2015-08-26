<?php

    require_once "src/Copy.php";
    require_once "src/Patron.php";

        /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copy::deleteAll();
            Patron::deleteAll();
        }
        function testGetBookId()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           //Act
           $result = $test_copy->getBookId();
           //Assert
           $this->assertEquals($book_id, $result);
        }

        function testGetId()
        {
            //Arrange
           $book_id = 1;
           $due_date = null;
           $id = 2;
           $test_copy = new Copy($book_id, $due_date, $id);
           //Act
           $result = $test_copy->getId();
           //Assert
           $this->assertEquals($id, $result);
        }

        function testGetDueDate()
        {
            //Arrange
           $book_id = 1;
           $due_date = "2015-12-12";
           $id = 2;
           $test_copy = new Copy($book_id, $due_date, $id);
           //Act
           $result = $test_copy->getDueDate();
           //Assert
           $this->assertEquals($due_date, $result);
        }

        function testsave()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           $test_copy->save();
           //Act
           $result = Copy::getAll();
           //Assert
           $this->assertEquals($test_copy, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           $test_copy->save();

           $book_id2 = 3;
           $test_copy2 = new Copy($book_id2);
           $test_copy2->save();
           //Act
           $result = Copy::getAll();

           //Assert
           $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           $test_copy->save();

           $book_id2 = 2;
           $test_copy2 = new Copy($book_id2);
           $test_copy2->save();
           //Act
           Copy::deleteAll();
           $result = Copy::getAll();
           //Assert
           $this->assertEquals([], $result);
        }
        function testUpdateBookId()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           $test_copy->save();

           $new_book_id = 3;

           //Act
           $test_copy->updateBookId($new_book_id);

           //Assert
           $this->assertEquals($test_copy->getBookId(), $new_book_id);
        }

        function testUpdateDueDate()
        {
            //Arrange
           $book_id = 1;
           $due_date = "2015-12-12";
           $test_copy = new Copy($book_id, $due_date);
           $test_copy->save();

           $new_due_date = "2012-21-21";

           //Act
           $test_copy->updateDueDate($new_due_date);

           //Assert
           $this->assertEquals($test_copy->getDueDate(), $new_due_date);
        }


        function testfind()
        {
            //Arrange
           $book_id = 1;
           $test_copy = new Copy($book_id);
           $test_copy->save();

           $book_id2 = 2;
           $test_copy2 = new Copy($book_id2);
           $test_copy2->save();

           //Act
           $result = Copy::find($test_copy2->getId());

           //Assert
           $this->assertEquals($test_copy2, $result);
        }
        function testGetPatron()
        {
            //Arrange
           $book_id = 1;
           $id = 1;
           $test_copy = new Copy($book_id, $id);
           $test_copy->save();

           $name = "Ping Pong";
           $id2 = 1;
           $test_patron = new Patron($name, $id2);
           $test_patron->save();

           $name2 = "Ding Dong";
           $id3 = 2;
           $test_patron2 = new Patron($name2, $id3);
           $test_patron2->save();

           //Act
           $test_copy->addPatron($test_patron->getId());
           $test_copy->addPatron($test_patron2->getId());

           //Assert
           $this->assertEquals($test_copy->getPatron(), [$test_patron, $test_patron2]);

        }
    }
 ?>
