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

        function getId()
          {
              return $this->id;
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

        static function find($search_id)
          {
              $found_review = null;
              $returned_reviews = $GLOBALS['DB']->prepare("SELECT * FROM reviews WHERE id = :id;");
              $returned_reviews->bindParam(':id', $search_id, PDO::PARAM_STR);
              $returned_reviews->execute();
              foreach($returned_reviews as $review) {
                  $review_title = $review['title'];
                  $review_stars = $review['stars'];
                  $review_content = $review['content'];
                  $review_restaurant_id = $review['restaurant_id'];
                  $review_id = $review['id'];
                  if ($review_id == $search_id) {
                    $found_review = new Review($review_title, $review_stars, $review_content, $review_restaurant_id, $review_id);
                  }
              }
              return $found_review;
          }

          function updateTitle($new_title)
          {
              $executed = $GLOBALS['DB']->exec("UPDATE reviews SET title = '{$new_title}' WHERE id = {$this->getId()};");
              if ($executed) {
                 $this->setTitle($new_title);
                 return true;
              } else {
                 return false;
              }
          }

          function updateStars($new_stars)
          {
              $executed = $GLOBALS['DB']->exec("UPDATE reviews SET stars = '{$new_stars}' WHERE id = {$this->getId()};");
              if ($executed) {
                 $this->setStars($new_stars);
                 return true;
              } else {
                 return false;
              }
          }

          function updateContent($new_content)
          {
              $executed = $GLOBALS['DB']->exec("UPDATE reviews SET content = '{$new_content}' WHERE id = {$this->getId()};");
              if ($executed) {
                 $this->setContent($new_content);
                 return true;
              } else {
                 return false;
              }
          }

          function updateRestaurantId($new_restaurant_id)
          {
              $executed = $GLOBALS['DB']->exec("UPDATE reviews SET restaurant_id = '{$new_restaurant_id}' WHERE id = {$this->getId()};");
              if ($executed) {
                 $this->setRestaurantId($new_restaurant_id);
                 return true;
              } else {
                 return false;
              }
          }

          function delete()
          {
              $executed = $GLOBALS['DB']->exec("DELETE FROM reviews WHERE id = {$this->getId()};");
               if (!$executed) {
                   return false;
               } else {
                   return true;
               }
          }
    }
?>
