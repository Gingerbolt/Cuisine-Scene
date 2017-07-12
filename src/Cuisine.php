<?php
  class Cuisine
  {
      private $name;
      private $id;

      function __construct($name, $id = null)
      {
          $this->name = $name;
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

      function getId()
        {
            return $this->id;
        }

      static function getAll()
      {
          $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
          $cuisines = array();
          foreach($returned_cuisines as $cuisine) {
              $name = $cuisine['name'];
              $id = $cuisine['id'];
              $new_cuisine = new Cuisine($name, $id);
              array_push($cuisines, $new_cuisine);
          }
          return $cuisines;
      }

      static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

      function save()
      {

          $executed = $GLOBALS['DB']->exec("INSERT INTO cuisine (name) VALUES ('{$this->getName()}')");
          if ($executed) {
               $this->id= $GLOBALS['DB']->lastInsertId();
               return true;
          } else {
               return false;
          }
      }

      static function find($search_id)
        {
            $found_cuisine = null;
            $returned_cuisines = $GLOBALS['DB']->prepare("SELECT * FROM cuisine WHERE id = :id");
            $returned_cuisines->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_cuisines->execute();
            foreach($returned_cuisines as $cuisine) {
                $cuisine_name = $cuisine['name'];
                $cuisine_id = $cuisine['id'];
                if ($cuisine_id == $search_id) {
                  $found_cuisine = new Cuisine($cuisine_name, $cuisine_id);
                }
            }
            return $found_cuisine;
        }

        function getRestaurants()
        {
            $restaurants = array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $description = $restaurant['description'];
                $cuisine_id = $restaurant['cuisine_id'];
                $restaurant_id = $restaurant['id'];
                $new_restaurant = new Restaurant($name, $description, $cuisine_id, $restaurant_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        function update($new_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE cuisine SET name = '{$new_name}' WHERE id = {$this->getId()};");
            if ($executed) {
               $this->setName($new_name);
               return true;
            } else {
               return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getId()};");
             if (!$executed) {
                 return false;
             }
             $executed = $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getId()};");
             if (!$executed) {
                 return false;
             } else {
                 return true;
             }
        }
  }
 ?>
