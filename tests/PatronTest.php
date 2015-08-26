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

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Copy::deleteAll();
        }
        function testGetName()
        {
            //Arrange
           $name = "Name";
           $test_patron = new Patron($name);
           //Act
           $result = $test_patron->getName();
           //Assert
           $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            //Arrange
           $name = "Name";
           $id = 1;
           $test_patron = new Patron($name, $id);
           //Act
           $result = $test_patron->getId();
           //Assert
           $this->assertEquals($id, $result);
        }

        function testsave()
        {
            //Arrange
           $name = "Name";
           $test_patron = new Patron($name);
           $test_patron->save();
           //Act
           $result = Patron::getAll();
           //Assert
           $this->assertEquals($test_patron, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
           $name = "Name";
           $test_patron = new Patron($name);
           $test_patron->save();

           $name2 = "New Name";
           $test_patron2 = new Patron($name2);
           $test_patron2->save();
           //Act
           $result = Patron::getAll();
           //Assert
           $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $name = "Name";
           $test_patron = new Patron($name);
           $test_patron->save();

           $name2 = "New Name";
           $test_patron2 = new Patron($name2);
           $test_patron2->save();
           //Act
           Patron::deleteAll();
           $result = Patron::getAll();
           //Assert
           $this->assertEquals([], $result);
        }
        function testUpdate()
        {
            //Arrange
           $name = "Name";
           $test_patron = new Patron($name);
           $test_patron->save();

           $new_name = "New Name";

           //Act
           $test_patron->update($new_name);

           //Assert
           $this->assertEquals($test_patron->getName(), $new_name);
        }

        function find()
        {
            //Arrange
           $name = "Name";
           $id = 1;
           $test_patron = new Patron($name, $id);

           $name2 = "Different Name";
           $id2 = 2;
           $test_patron2 = new Patron($name2, $id2);

           //Act
           $result = Patron::find($test_patron2->getId());

           //Assert
           $this->assertEquals($test_student2, $result);
        }

        function testGetCopy()
        {
            //Arrange
           $copy_id = 1;
           $test_copy = new Copy($copy_id);
           $test_copy->save();

           $copy_id2 = 2;
           $id2 = 2;
           $test_copy2 = new Copy($copy_id2);
           $test_copy2->save();

           $name = "Ping Pong";
           $id2 = 1;
           $test_patron = new Patron($name);
           $test_patron->save();


           //Act
           $test_patron->addCopy($test_copy->getId());
           $test_patron->addCopy($test_copy2->getId());

           //Assert
           $this->assertEquals($test_patron->getCopy(), [$test_copy, $test_copy2]);

        }
    }
 ?>
