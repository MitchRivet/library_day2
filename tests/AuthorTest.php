<?php

    require_once "src/Book.php";
    require_once "src/Author.php";

        /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }
        function testGetName()
        {
            //Arrange
           $name = "Name";
           $test_author = new Author($name);
           //Act
           $result = $test_author->getName();
           //Assert
           $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            //Arrange
           $name = "Name";
           $id = 1;
           $test_author = new Author($name, $id);
           //Act
           $result = $test_author->getId();
           //Assert
           $this->assertEquals($id, $result);
        }

        function testsave()
        {
            //Arrange
           $name = "Name";
           $test_author = new Author($name);
           $test_author->save();
           //Act
           $result = Author::getAll();
           //Assert
           $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
           $name = "Name";
           $test_author = new Author($name);
           $test_author->save();

           $name2 = "New Name";
           $test_author2 = new Author($name2);
           $test_author2->save();
           //Act
           $result = Author::getAll();
           //Assert
           $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $name = "Name";
           $test_author = new Author($name);
           $test_author->save();

           $name2 = "New Name";
           $test_author2 = new Author($name2);
           $test_author2->save();
           //Act
           Author::deleteAll();
           $result = Author::getAll();
           //Assert
           $this->assertEquals([], $result);
        }
        function testUpdate()
        {
            //Arrange
           $name = "Name";
           $test_author = new Author($name);
           $test_author->save();

           $new_name = "New Name";

           //Act
           $test_author->update($new_name);

           //Assert
           $this->assertEquals($test_author->getName(), $new_name);
        }

        function find()
        {
            //Arrange
           $name = "Name";
           $id = 1;
           $test_author = new Author($name, $id);

           $name2 = "Different Name";
           $id2 = 2;
           $test_author2 = new Author($name2, $id2);

           //Act
           $result = Author::find($test_author2->getId());

           //Assert
           $this->assertEquals($test_student2, $result);
        }
    }
 ?>
