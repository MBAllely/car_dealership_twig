<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();

    $porsche = new Car("2014 Porsche 911", 114991, "img/porsche.jpg", 7864);
    $ford = new Car("2011 Ford F450", 55995, "img/ford.jpg", 14241);
    $lexus = new Car("2013 Lexus RX 350", 44700, "img/lexus.jpg", 20000);
    $mercedes = new Car("Mercedes Benx CLS550", 39900, "img/mercedes.jpg", 37979);

    if(empty($_SESSION['cars'])) {
        $_SESSION['cars'] = array($porsche, $ford, $lexus, $mercedes);
    }
    if(empty($_SESSION['matching_cars'])) {
        $_SESSION['matching_cars'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__."/../views"));


    $app->get("/", function() use ($app) {
        return $app['twig']->render('car_dealership_form.html.twig', array('cars' => Car::getAll()));
    });

    $app->get("/results", function() use ($app) {
        $user_price = intval($_GET['user_price']);
        $user_miles = intval($_GET['user_miles']);
        $cars = $_SESSION['cars'];
        $cars_matching_search = array();

        foreach ($cars as $car) {
            if ($car->worthBuying($user_price) && $car->maxMileage($user_miles)) {
                (array_push($cars_matching_search, $car));
            }
        }
        return $app['twig']->render('car_search_results.html.twig',  array('matching_cars' => $cars_matching_search));
    });

    $app->get("/add_listing", function() use ($app) {
        return $app['twig']->render('car_add_listing.html.twig');
    });

    $app->post("/new_listing", function() use ($app) {
        $new_car = new Car($_POST['user_model'], $_POST['user_price'], $_POST['user_image'], $_POST['user_miles']);
        $new_car->save();
        return $app['twig']->render('new_listing.html.twig', array('new_car' => $new_car));
    });

    $app->post("/delete", function() use ($app) {
        Car::deleteAll();
        return $app['twig']->render('delete.html.twig');
    });

    return $app;
?>
