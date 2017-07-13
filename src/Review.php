<?php
    class Review
    {
        private $id;
        private $title;
        private $stars;
        private $content;
        private $restaurant_id;

        function __construct($id = null, $title, $stars, $content, $restaurant_id)
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
            $this->restaurant_id = (string) $new_restaurant_id;
        }

        function getRestaurantId()
        {
            return $this->restaurant_id;
        }
    }
?>
