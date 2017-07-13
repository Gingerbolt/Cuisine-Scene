<?php
    class Review
    {
        private $id;
        private $title;
        private $stars;
        private $content;
        private $restaurant_id;

        function __construct($title, $stars, $content, $restaurant_id, $id = null)
        {
            $this->id = $id;
            $this->title = $title;
            $this->stars = $stars;
            $this->content = $content;
            $this->restaurant_id = $restaurant_id;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setStars($new_stars)
        {
            $this->stars = (int) $new_stars;
        }

        function getStars()
        {
            return $this->stars;
        }

        function setContent($new_content)
        {
            $this->content = (string) $new_content;
        }

        function getContent()
        {
            return $this->content;
        }

        function setRestaurantId($new_restaurant_id)
        {
            $this->restaurant_id = (int) $new_restaurant_id;
        }

        function getRestaurantId()
        {
            return $this->restaurant_id;
        }

        function save()
        {

            $executed = $GLOBALS['DB']->exec("INSERT INTO reviews (title, stars, content, restaurant_id) VALUES ('{$this->getTitle()}', '{$this->getStars()}', '{$this->getContent()}', '{$this->getRestaurantId()}');");
            if ($executed) {
                 $this->id= $GLOBALS['DB']->lastInsertId();
                 return true;
            } else {
                 return false;
            }
        }

        static function getAll()
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
            $reviews = array();
            foreach($returned_reviews as $review) {
                $id = $review['id'];
                $title = $review['title'];
                $stars = $review['stars'];
                $content = $review['content'];
                $restaurant_id = $review['restaurant_id'];
                $new_review = new Review($title, $stars, $content, $restaurant_id, $id);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }

        static function deleteAll()
          {
            $GLOBALS['DB']->exec("DELETE FROM reviews;");
          }
    }
?>
