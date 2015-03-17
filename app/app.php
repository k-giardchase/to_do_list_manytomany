<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Task.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=to_do');
    //leads to the views directory
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    //creates path to our index/renders our index
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('categories' => Category::getAll()));
    });
    //creates the path tasks page/renders our tasks page
    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });
    //creates the path to categories page/renders our categories page
    $app->get("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });
    $app->get("/categories/{id}", function($id) use ($app) {
        $category = Category::findTask($id);
        return $app['twig']->render('category.twig', array('category' => $category, 'tasks' => $category->getTasks()));
    });
    //calls on our save function and posts saved cats, renders cats
    $app->post("/categories", function() use ($app){
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('index.twig', array('categories' => Category::getAll()));
    });
    //calls on our save function and posts saved tasks, renders tasks
    $app->post("/tasks", function() use ($app) {
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $task = new Task($description, $id = null, $category_id);
        $task->save();
        $category = Category::findTask($category_id);
        return $app['twig']->render('category.twig', array('category' => $category, 'tasks' => Task::getAll()));
    });
    //creates path to delete_cat page, calls on delete function, clears save
    $app->post("/delete_cat", function() use ($app){
        Category::deleteAll();
        return $app['twig']->render('delete_cat.twig');
    });
    //creats path to delete_task, calls on delete function, clears save
    $app->post("/delete_task", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_task.twig');
    });

    return $app;

?>
