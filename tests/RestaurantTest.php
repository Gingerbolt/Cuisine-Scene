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

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
          Restaurant::deleteAll();
        }

        function testSave()
        {
          //Arrange
          $name = "Work stuff";
          $test_restaurant = new Restaurant($name);

          //Act
          $executed = $test_restaurant->save();

          // Assert
          $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $cuisine_id = $test_cuisine->getId();

            $name = "Wash the dog";
            $id = null;
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();

            $name_2 = "Water the lawn";
            $id_2 = null;
            $test_restaurant_2 = new Restaurant($name_2, $cuisine_id, $id);
            $test_restaurant_2->save();

            //Act
            Restaurant::deleteAll();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function testGetID()
        {
            //Arrange
            $name = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name = "Wash the dog";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
    }
?>
