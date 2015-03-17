<?php

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class Category
    {
        private $name;
        private $id;
        //creates and object with our two variables
        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        //sets name property
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }
        //retrives name property
        function getName()
        {
            return $this->name;
        }
        //retrives Id property
        function getId()
        {
            return $this->id;
        }
        //retrieves Id property
        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }
        //queries the datbase and fetches/returns id of saved category
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO categories (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }
        //queries the database returns names and id's from database and turns them into variables/pushes into array
        static function getAll()
        {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            $categories = array();
            foreach ($returned_categories as $category){
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }
        //deletes the saved information gathered from the database
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories *;");
        }
        //allows to search for specific categories within our table
        static function findTask($search_id)
        {
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category){
                $category_id = $category->getId();
                if($category_id == $search_id){
                    $found_category = $category;
                }
            }
            return $found_category;
        }
        function getTasks()
        {
            $tasks = Array();
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE category_id = {$this->getId()};");
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $category_id = $task['category_id'];
                $new_task = new Task($description, $id, $category_id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
    }
?>
