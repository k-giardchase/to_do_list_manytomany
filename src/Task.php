<?php

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class Task
    {
        private $description;
        private $category_id;
        private $id;

        //creates and object with our two variables
        function __construct($description, $id = null, $category_id)
        {
            $this->description = $description;
            $this->id = $id;
            $this->category_id = $category_id;
        }

    //sets description property
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }
    //gets description property
        function getDescription()
        {
            return $this->description;
        }
    //gets id property
        function getId()
        {
            return $this->id;
        }

    //sets id property
        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

    //sets category_id property
        function setCategoryId($new_category_id)
        {
            $this->category_id = (int) $new_category_id;
        }

        //gets category_id property
        function getCategoryId()
        {
            return $this->category_id;
        }

    //queries the datbase and fetches/returns id of saved tasks
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description, category_id) VALUES ('{$this->getDescription()}', {$this->getCategoryId()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        //queries the database returns names and id's from database and turns them into variables/pushes into array
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");

            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $category_id = $task['category_id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
        //deletes the saved information gathered from the database
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks *;");
        }
        //allows to search for specific categories within our table
        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task) {
                $task_id = $task->getId();
                if ($task_id == $search_id) {
                    $found_task = $task;
                }
            }
            return $found_task;
        }
    }
?>
