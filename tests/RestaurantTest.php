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
    }
?>
