<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Review.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=bestaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' =>__DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()));
    });

    $app->post("/review", function() use ($app) {
      $title = $_POST['title'];
      $stars = $_POST['stars'];
      $content = $_POST['content'];
      $restaurant_id = $_POST['restaurant_id'];
      $new_review = New Review($title, $stars, $content, $restaurant_id, $id = null);
      $new_review->save();
      $restaurant = Restaurant::find($restaurant_id);
      return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()));
    });

    $app->post("/restaurants", function() use ($app) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $cuisine_id = $_POST['cuisine_id'];
      $restaurant = new Restaurant($name, $description, $cuisine_id, $id = null);
      $restaurant->save();
      $cuisine = Cuisine::find($cuisine_id);
      return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get("/cuisines", function() use ($app) {
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['name']);
        $cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($name);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->delete("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->delete();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
      Cuisine::deleteAll();
      return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_restaurants", function() use ($app) {
        Restaurant::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
