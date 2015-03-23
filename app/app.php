<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Task.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=to_do');
    //leads to the views directory
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //creates path to our index/renders our index
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('categories' => Category::getAll(), 'tasks' => Task::getAll()));
    });

    //creates the path tasks page/renders our tasks page
    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    //creates the path to categories page/renders our categories page
    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });

    //calls on our save function and posts saved tasks, renders tasks
    $app->post("/tasks", function() use ($app) {
        $description = $_POST['description'];
        $task = new Task($description);
        $task->save();
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    //calls on our save function and posts saved tasks, renders tasks
    $app->get("/tasks/{id}", function($id) use ($app) {
        $task = Task::findTask($id);
        return $app['twig']->render('task.twig', array('task' => $task, 'categories' => $task->getCategories(), 'all_categories' => Category::getAll()));
    });

    //calls on our save function and posts saved cats, renders cats
    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });

    //calls on our save function and posts saved cats, renders cats
    $app->get("/categories/{id}", function($id) use ($app) {
        $category = Category::find($id);
        return $app['twig']->render('category.twig', array('category' => $category, 'tasks' => $category->getTasks(), 'all_tasks' => Task::getAll()));
    });

    $app->post('/add_tasks', function() use ($app) {
        $category = Category::find($_POST['category_id']);
        $task = Task::findTask($_POST['task_id']);
        $category->addTask($task);
        return $app['twig']->render('category.twig', array('category' => $category, 'categories' => Category::getAll(), 'tasks' => $category->getTasks(), 'all_tasks' => Task::getAll()));
    });

    $app->post('/add_categories', function() use ($app) {
        $category = Category::find($_POST['category_id']);
        $task = Task::findTask($_POST['task_id']);
        $task->addCategory($category);
        return $app['twig']->render('task.twig', array('task' => $task, 'tasks' => Task::getAll(), 'categories' => $task->getCategories(), 'all_categories' => Category::getAll()));
    });

    //creates path to delete_cat page, calls on delete function, clears save
    $app->post("/delete_categories", function() use ($app){
        Category::deleteAll();
        return $app['twig']->render('index.twig', array('categories' => Category::getAll()));
    });

    //creats path to delete_task, calls on delete function, clears save
    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    return $app;

?>
