<?php
 class Car
 {
        private $make_model;
        private $price;
        private $image;
        private $miles;

        function __construct($make_model, $car_price, $car_image, $car_miles)
        {
            $this->model = $make_model;
            $this->price = $car_price;
            $this->image = $car_image;
            $this->miles = $car_miles;
        }

        function worthBuying($max_price)
        {
            return $this->price < ($max_price + 100);
        }

        function maxMileage($max_mileage)
        {
            return $this->miles <= ($max_mileage);
        }

        function getModel()
        {
            return $this->model;
        }

        function setModel($new_model)
        {
            $this->model = $new_model;
        }

        function getPrice()
        {
            return $this->price;
        }

        function setPrice($new_price)
        {
            $this->price = $new_price;
        }

        function getImage()
        {
            return $this->image;
        }
        function setImage($new_image)
        {
            $this->image = $new_image;
        }

        function getMiles()
        {
            return $this->miles;
        }

        function setMiles($new_miles)
        {
            $this->miles = $new_miles;
        }

        static function getAll()
        {
            return $_SESSION['cars'];
        }

}
?>
