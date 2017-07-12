<?php
    class Restaurant
    {
        private $name;
        private $cuisine_id;
        private $id;

        function __construct($name, $cuisine_id = null, $id = null)
        {
            $this->name = $name;
            $this->cuisine_id = $cuisine_id;
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

        function getCuisineID()
        {
            return $this->cuisine_id;
        }

        function setCuisineID($new_cuisine_id)
        {
            $this->cuisine_id = $new_cuisine_id;
        }

        function save()
        {

            $executed = $GLOBALS['DB']->exec("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', '{$this->getCuisineID()}')");
            if ($executed) {
                 $this->id= $GLOBALS['DB']->lastInsertId();
                 return true;
            } else {
                 return false;
            }
        }



    }

 ?>
