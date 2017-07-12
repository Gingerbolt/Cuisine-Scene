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
          $this->assertTrue($executed, "Cuisine not successfully saved to database");
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

        function testFind()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();
            $test_cuisine_2 = new Cuisine($name2);
            $test_cuisine_2->save();

            //Act
            $result = Cuisine::find($test_cuisine->getId());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }

        function testGetRestaurants()
        {
            //Arrange
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $name = "Email client";
            $description = "One great description goes here";
            $test_restaurant = new Restaurant($name, $description, $test_cuisine_id);
            $test_restaurant->save();

            $name_2 = "Meet with boss";
            $description_2 = "Second great description goes here";
            $test_restaurant_2 = new Restaurant($name_2, $description_2, $test_cuisine_id);
            $test_restaurant_2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant_2], $result);
        }

        function testUpdate()
        {
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $new_name = "Home stuff";

            $test_cuisine->update($new_name);

            $this->assertEquals("Home stuff", $test_cuisine->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name_2 = "Home stuff";
            $test_cuisine_2 = new Cuisine($name_2);
            $test_cuisine_2->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([$test_cuisine_2], Cuisine::getAll());
        }

        function testDeleteCuisineRestaurants()
        {
            //Arrange
            $name = "Work stuff";
            $test_cuisine = new Cuisine($name);
            $test_cuisine->save();

            $name = "Build website";
            $description = "A third great description goes here";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $description, $cuisine_id);
            $test_restaurant->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }
    }
?>
