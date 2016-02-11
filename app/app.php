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
        return $app['twig']->render('car_dealership_form.html.twig');
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

    return $app;
?>
