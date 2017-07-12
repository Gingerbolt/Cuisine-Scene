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
  }
 ?>
