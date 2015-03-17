<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Task.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=to_do');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });

    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });

    $app->post("/categories", function() use ($app){
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });

    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    $app->post("/delete_cat", function() use ($app){
        Category::deleteAll1();
        return $app['twig']->render('delete_cat.twig');
    });


    $app->post("/delete_task", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_task.twig');
    });

    return $app;

?>
