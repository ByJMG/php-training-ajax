<?php

namespace AppBundle\Entity;

use Ramsey\Uuid\Uuid;

class Cars
{
    /**
   * Id of the car.
   *
   * @var int
   */
  private $id;
  /**
   * Model of the car.
   *
   * @var string
   */
  private $model;
  /**
   * The constructo who build the car.
   *
   * @var string
   */
  private $make;
  /**
   * Price of the car.
   *
   * @var float
   */
  private $price;
  /**
   * Is the car available.
   *
   * @var bool
   */
  private $available;
  /**
   * Color of the car.
   *
   * @var string
   */
  private $color;

  public function __construct(){
    $this->available = true;
    $uuid = Uuid::uuid4();
    $this->id = $uuid->toString();
  }

    /**
     * Get the value of Id of the car.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

public function setId($id){
  $this->id = $id;
  return $this;
}
    /**
     * Get the value of Model of the car.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of Model of the car.
     *
     * @param string model
     *
     * @return self
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of The constructo who build the car.
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set the value of The constructo who build the car.
     *
     * @param string make
     *
     * @return self
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get the value of Price of the car.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of Price of the car.
     *
     * @param float price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of Is the car available.
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set the value of Is the car available.
     *
     * @param bool available
     *
     * @return self
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get the value of Color of the car.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of Color of the car.
     *
     * @param string color
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
