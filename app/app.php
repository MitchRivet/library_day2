<?php

    //set up
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Copy.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Record.php";

    // enabling pach and delete http methods so we can use them in our routes
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //creating a silex application
    $app = new Silex\Application();

    $app['debug'] = true;

    //providing the details of the server we're using
    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //pointing twig towards the views folder
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //getting the initial page
    $app->get("/", function() use ($app) {
            return $app['twig']->render('index.html.twig', array(
                'patrons' => Patron::getAll()
            ));
        });

    //posting patron name to initial page
    $app->post("/patrons", function() use ($app) {
            $patron = new Patron(
            $_POST['name']
        );

        //save that patron name to index.html
        $patron->save();
        return $app['twig']->render('index.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    $app->get("/patrons_edit", function() use ($app){
        return $app['twig']->render('patrons_edit.html.twig', array(
            'patrons' => Patron::getAll(),
        ));
    });

    $app->post("/patrons_edit", function() use ($app) {
            $patron = new Patron($_POST['name']);
            $patron->save();
            return $app['twig']->render('patrons_edit.html.twig',
            array('patrons' => Patron::getAll()));
    });


    // get patrons id form books_patron
    $app->get("/patrons/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        return $app['twig']->render('books_patron.html.twig', array(
            'patron' => $patron,
            'books' => Book::getAll()

        ));
    });

    // get the list books inventory for the librarian
    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render('librarian.html.twig');
    });


    // from the books_edit page edit a individaul page
    $app->get("/books_edit", function() use ($app){
        return $app['twig']->render('books_edit.html.twig', array(
            'books' => Book::getAll(),
        ));
    });


    // add a new book adn author to the page in books_edit
    $app->post("/add_books", function() use ($app) {
        $book = new Book($_POST['title']);
        $author = new Author($_POST['name']);
        $author->save();
        $book->save();
        $book->addAuthor($author);
        return $app['twig']->render('books_edit.html.twig', array(
            'books' => Book::getAll(),
            'authors' => $author
        ));

    });


    // get book id from book.html.twig
    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array(
            'book' => $book, 'author' => $book->getAuthor()
        ));
    });


    // delete a book and its id from the edit books page
    $app->delete("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->deleteBook();
        return $app['twig']->render('books_edit.html.twig', array('books' => Book::getAll()));
    });


    // update a book id and rednder it to book.html
    $app->patch("/books/{id}", function($id) use ($app) {
        $title = $_POST['title'];
        $name = $_POST['name'];
        $book = Book::find($id);
        $book->update($title);
        $author = Author::find($id);
        $author->update($name);
        return $app ['twig']->render('book.html.twig', array(
            'book' => $book, 'author' => $book->getAuthor()
        ));
    });


    return $app;

?>
