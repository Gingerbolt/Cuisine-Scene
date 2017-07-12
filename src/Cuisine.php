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
  }
 ?>
