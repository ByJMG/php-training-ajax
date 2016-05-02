<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Cars;
use AppBundle\Manager\CarsManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Filesystem\Filesystem;

class LoadCarsData
{
    public function load($fileName)
    {
        $cars = [];
        $car1 = new Cars();
        $car1->setModel('206')
        ->setMake('Peugeot')
        ->setPrice(25)
        ->setAvailable(true)
        ->setColor('white')
        ;

        $car2 = new Cars();
        $car2->setModel('Clio')
        ->setMake('Renault')
        ->setPrice(25)
        ->setAvailable(true)
        ->setColor('blue')
        ;

        $car3 = new Cars();
        $car3->setModel('F430')
        ->setMake('Ferrari')
        ->setPrice(400)
        ->setAvailable(true)
        ->setColor('red')
        ;

        $cars = [$car1, $car2, $car3];

        $carsManager = new CarsManager($fileName);
        return $carsManager->saveCarsToJson($cars);
    }
}
