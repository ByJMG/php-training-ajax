<?php

namespace AppBundle\Manager;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\Cars;
use Symfony\Component\Filesystem\Filesystem;

class CarsManager{

  private $jsonFile;

  public function __construct($jsonFilePath){
    $this->jsonFile = $jsonFilePath;
  }

  /**
   * Get all cars
   * @return Array of entities
   */
  public function getAllCars(){

    $encoders = array(new JsonEncoder());

    $normalizers = array(new PropertyNormalizer(), new ArrayDenormalizer());

    $serializer = new Serializer($normalizers, $encoders);

    $jsonFilesData = file_get_contents($this->jsonFile);

    $cars = $serializer->deserialize($jsonFilesData, 'AppBundle\Entity\Cars[]', 'json');

    return $cars;

  }

  /**
   * Get a car according to the id
   * @param  string $id uuid of the car
   * @return Car|false
   */
  public function getCar($id){
    $cars = $this->getAllCars();

    $car = null;

    foreach($cars as $c){
      if($c->getId() == $id){
        $car = $c;
        break;
      }
    }

    if($car === null){
      return false;
    }else{
      return $car;
    }
  }
  /**
   * Get a car in json format
   * @param  string $id uuid of the car
   * @return JSON|false
   */
  public function getCarJson($id){
    $car = $this->getCar($id);
    if($car !== false){
      $encoders = array(new JsonEncoder());

      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      return $serializer->serialize($car, 'json');

    }else{
      return false;
    }

  }

/**
 *
 * @param  array $cars array of cars
 * @return Boolean  return true if save succeed, false otherwise
 */
  public function saveCarsToJson($cars){
    $encoders = array(new JsonEncoder());
    $normalizers = array(new ObjectNormalizer());

    $serializer = new Serializer($normalizers, $encoders);

    $carsJson = $serializer->serialize($cars, 'json');

    $fs = new Filesystem();
    if ($fs->exists($this->jsonFile)) {
        $fs->dumpFile($this->jsonFile, $carsJson);

        return true;
    } else {
        return false;
    }
  }

/**
 * Add a single car
 * @param Cars $car
 */
  public function addCar(Cars $car){
    $cars = $this->getAllCars();
    $cars[] = $car;
    return $this->saveCarsToJson($cars);
  }

/**
 * Delete a car
 * @param  string $id UUID of the car
 * @return array|false  return the new list of cars when delete succeed or false otherwise
 */
  public function deleteCar($id){
    $cars = $this->getAllCars();
    $originalCarsSize = count($cars);

    $newCars = [];

    foreach($cars as $c){
      if($c->getId() != $id){
        $newCars[] = $c;
      }
    }

    if(count($newCars) === $originalCarsSize){
      return false;
    }else{
      if($this->saveCarsToJson($newCars)){
        return $newCars;
      }else{
        return false;
      }
    }
  }

/**
 * Read the json file
 * @return string
 */
  public function getAllCarsJson(){
    return file_get_contents($this->jsonFile);
  }



}
