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
        $patron->save();
        return $app['twig']->render('index.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    $app->get("/patrons/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        return $app['twig']->render('books_patron.html.twig', array(
            'patron' => $patron,
            'books' => Book::getAll()

        ));
    });

    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render('librarian.html.twig');
    });

    $app->get("/books_edit", function() use ($app){
        return $app['twig']->render('books_edit.html.twig', array(
            'books' => Book::getAll(),
        ));
    });

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

    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array(
            'book' => $book, 'author' => $book->getAuthor()
        ));
    });


    return $app;

?>
