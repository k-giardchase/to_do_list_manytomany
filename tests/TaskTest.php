<?php

/**
*@backupGlobals disabled
*@backupStaticAttributes disabled
*/

    require_once "src/Task.php";
    require_once "src/Category.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function testGetDescription()
        {
            //Arrange
            $description = "Do the Dishes";
            $test_task = new Task($description);

            //Act
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function testSetDescription()
        {
            $description = "Do dishes";
            $test_task = new Task($description);

            $test_task->setDescription("Drink Coffee");
            $result = $test_task->getDescription();

            $this->assertEquals("Drink Coffee", $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_setId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);
            $test_task->save();

            //Act
            $test_task->setId(2);

            //Assert
            $result = $test_task->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $category_id = $test_category->getId();
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function testSaveSetsId()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);

            $test_task->save();

            $this->assertEquals(true, is_numeric($test_task->getId()));
        }

        function test_GetAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function test_findTask()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();


            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //Act
            $result = Task::findTask($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function test_Update()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $new_description = "Clean the dog";

            $test_task->Update($new_description);

            $this->assertEquals("Clean the dog", $test_task->getDescription());
        }

        function test_delete()
        {
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            $test_task->addCategory($test_category);
            $test_task->delete();

            $this->assertEquals([], $test_category->getTasks());
        }

        function testAddCategory()
        {
            //Arrange
            $name = 'Work stuff';
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = 'File reports';
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            $name = 'Work stuff';
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = 'Volunteer stuff';
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $description = 'File reports';
            $id3 = 3;
            $test_task = new Task($description, $id3);
            $test_task->save();

            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }
    }

?>
