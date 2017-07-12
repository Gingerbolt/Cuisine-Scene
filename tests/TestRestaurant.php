<?php
    require_once "src/Restaurant.php"
    require_once "src/Cuisine.php"

    $server = 'mysql:host=localhost:8889;dbname=test_bestaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TestRestaurant extends PHPUnit_Framework_TestCase
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
