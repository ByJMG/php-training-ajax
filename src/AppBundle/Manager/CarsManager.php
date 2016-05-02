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

  public function getAllCars(){
    //Serialize the cars object
    $encoders = array(new JsonEncoder());

    $normalizers = array(new PropertyNormalizer(), new ArrayDenormalizer());

    $serializer = new Serializer($normalizers, $encoders);

    $jsonFilesData = file_get_contents($this->jsonFile);

    $cars = $serializer->deserialize($jsonFilesData, 'AppBundle\Entity\Cars[]', 'json');

    return $cars;

  }

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

  public function addCar(Cars $car){
    $cars = $this->getAllCars();
    $cars[] = $car;
    return $this->saveCarsToJson($cars);
  }


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

  public function getAllCarsJson(){
    return file_get_contents($this->jsonFile);
  }



}
