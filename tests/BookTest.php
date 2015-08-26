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

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }
        function testGetTitle()
        {
            //Arrange
           $title = "Title";
           $test_book = new Book($title);
           //Act
           $result = $test_book->getTitle();
           //Assert
           $this->assertEquals($title, $result);
        }

        function testGetId()
        {
            //Arrange
           $title = "Title";
           $id = 1;
           $test_book = new Book($title, $id);
           //Act
           $result = $test_book->getId();
           //Assert
           $this->assertEquals($id, $result);
        }

        function testsave()
        {
            //Arrange
           $title = "Title";
           $test_book = new Book($title);
           $test_book->save();
           //Act
           $result = Book::getAll();
           //Assert
           $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
           $title = "Title";
           $test_book = new Book($title);
           $test_book->save();

           $title2 = "New Title";
           $test_book2 = new Book($title2);
           $test_book2->save();
           //Act
           $result = Book::getAll();
           //Assert
           $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
           $title = "Title";
           $test_book = new Book($title);
           $test_book->save();

           $title2 = "New Title";
           $test_book2 = new Book($title2);
           $test_book2->save();
           //Act
           Book::deleteAll();
           $result = Book::getAll();
           //Assert
           $this->assertEquals([], $result);
        }
        function testUpdate()
        {
            //Arrange
           $title = "Title";
           $test_book = new Book($title);
           $test_book->save();

           $new_title = "New Title";

           //Act
           $test_book->update($new_title);

           //Assert
           $this->assertEquals($test_book->getTitle(), $new_title);
        }

        function testfind()
        {
            //Arrange
           $title = "Title";
           $id = 1;
           $test_book = new Book($title, $id);
           $test_book->save();

           $title2 = "Different Title";
           $id2 = 2;
           $test_book2 = new Book($title2, $id2);
           $test_book2->save();

           //Act
           $result = Book::find($test_book2->getId());

           //Assert
           $this->assertEquals($test_book2, $result);
        }
        function testGetAuthor()
        {
            //Arrange
           $title = "Title";
           $id = 1;
           $test_book = new Book($title, $id);
           $test_book->save();

           $name = "Ping Pong";
           $id2 = 1;
           $test_author = new Author($name, $id2);
           $test_author->save();

           $name2 = "Ding Dong";
           $id3 = 2;
           $test_author2 = new Author($name2, $id3);
           $test_author2->save();

           //Act
           $test_book->addAuthor($test_author->getId());
           $test_book->addAuthor($test_author2->getId());

           //Assert
           $this->assertEquals($test_book->getAuthor(), [$test_author, $test_author2]);

        }
    }
 ?>
