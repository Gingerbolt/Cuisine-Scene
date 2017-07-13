<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";
    require_once "src/Review.php";

    $server = 'mysql:host=localhost:8889;dbname=bestaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
            Review::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $title = "Work stuff";
            $stars = 1;
            $content = "some stuff here";
            $restaurant_id = 2;
            $test_review = new Review($title, $stars, $content, $restaurant_id);

            //Act
            $executed = $test_review->save();

            // Assert
            $this->assertTrue($executed, "Review not successfully saved to database");
        }

        function testDeleteAll()
        {
            //Arrange
            $title = "Wash the dog";
            $title_2 = "Home stuff";
            $stars = 3;
            $stars_2 = 4;
            $content = "some more stuff here";
            $content_2 = "even more stuff";
            $restaurant_id = 6;
            $restaurant_id_2 = 9;
            $test_review = new Review($title, $stars, $content, $restaurant_id);
            $test_review->save();
            $test_review_2 = new Review($title_2, $stars_2, $content_2, $restaurant_id_2);
            $test_review_2->save();

            //Act
            Review::deleteAll();
            $result = Review::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testGetAll()
        {
            //Arrange
            $title = (string) "sux";
            $title_2 = (string) "blows";
            $stars = 5;
            $stars_2 = 1;
            $content = "even more stuff here";
            $content_2 = "much more stuff";
            $restaurant_id = 12;
            $restaurant_id_2 = 14;
            $test_review = new Review($title, $stars, $content, $restaurant_id);
            $test_review->save();
            $test_review_2 = new Review($title_2, $stars_2, $content_2, $restaurant_id_2);
            $test_review_2->save();

            //Act
            $result = Review::getAll();
            //Assert
            $this->assertEquals([$test_review, $test_review_2], $result);
        }

        function testGetTitle()
        {
            //Arrange
            $title = "Work stuff";
            $stars = 1;
            $content = "even more stupid stuff here";
            $restaurant_id = 16;
            $test_review = new Review($title, $stars, $content, $restaurant_id);

            //Act
            $result = $test_review->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function testGetId()
        {
            //Arrange
            $title = "Work stuff";
            $stars = 1;
            $content = "even more stupid stuff here";
            $restaurant_id = 16;
            $test_review = new Review($title, $stars, $content, $restaurant_id);
            $test_review->save();

            //Act
            $result = $test_review->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

    }
?>
