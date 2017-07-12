<?php
  class Cuisine
  {
      private $name;
      private $restaurant_id;
      private $id;

      function __construct($name, $restaurant_id = null, $id = null)
      {
          $this->name = $name;
          $this->restaurant_id = $restaurant_id;
          $this->id = $id;
      }

      function setName($new_name)
      {
        $this->name = (string) $new_name;
      }

      function getName()
      {
          return $this->name;
      }

      function getRestaurantID()
      {
          return $this->restaurant_id;
      }

      function setCuisineID($new_restaurant_id)
      {
          $this->restaurant_id = $new_restaurant_id;
      }

      function save()
      {

          $executed = $GLOBALS['DB']->exec("INSERT INTO cuisine (name, restaurant_id) VALUES ('{$this->getName()}', '{$this->getRestaurantID()}')");
          if ($executed) {
               $this->id= $GLOBALS['DB']->lastInsertId();
               return true;
          } else {
               return false;
          }
      }
  }
 ?>
