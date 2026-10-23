<?php
class Dish {
  const CURRENCY = "GHS";

  public $name;
  protected $price;
  public static $count = 0;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
    self::$count++;
  }

  public function describe() {
    return $this->name . " - " . self::CURRENCY . " " . $this->price;
  }

  // Public method that gives access to the protected price
  public function getPrice() {
    return $this->price;
  }

  public static function getCount() {
    return self::$count;
  }

  public function __destruct() {
    echo "Removing " . $this->name . "<br>";
  }
}

class Drink extends Dish {
  public $size;

  public function __construct($name, $price, $size) {
    parent::__construct($name, $price); // also increases Dish::$count
    $this->size = $size;
  }

  // Overrides Dish::describe() and adds the size
  public function describe() {
    return parent::describe() . " (" . $this->size . ")";
  }
}