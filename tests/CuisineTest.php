<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=bestaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
          Restaurant::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);

            //Act
            $result = $test_cuisine->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSave()
        {
          //Arrange
          $name = "Sushi Mori";
          $test_cuisine = new Cuisine($name);

          //Act
          $executed = $test_cuisine->save();

          // Assert
          $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testGetId()
        {
            //Arrange
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
          //Arrange
          $name = "Pizza Capri";
          $name_2 = "New Seasons";
          $test_cuisine = new Cuisine($name);
          $test_cuisine->save();
          $test_cuisine_2 = new Cuisine($name_2);
          $test_cuisine_2->save();

          //Act
          $result = Cuisine::getAll();

          //Assert
          $this->assertEquals([$test_cuisine, $test_cuisine_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $name_2 = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $test_cuisine_2 = new Cuisine($name_2);
            $test_cuisine_2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
