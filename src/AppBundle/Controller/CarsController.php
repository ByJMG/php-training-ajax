<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\DataFixtures\LoadCarsData;
use AppBundle\Entity\Cars;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CarsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return new Response('Cars api v 0.1');
    }

    /**
     * @Route("/load-cars-fixtures", name="app_cars_load_fixtures")
     */
    public function loadCarsFixturesAction(Request $request)
    {
        $message = '';
        $jsonFile = $this->getParameter('jsonPathFile');
        $carFixtures = new LoadCarsData();

        if ($carFixtures->load($jsonFile)) {
            $message = 'Fixtures Loaded';
        } else {
            $message = 'Fixtures not loaded';
        }

        return new Response($message);
    }

    /**
     * @Route("/cars", name="app_cars_list")
     * @Method({"GET"})
     */
    public function carsAction()
    {
        $carsManager = $this->get('app.cars_manager');
        $jsonData = $carsManager->getAllCarsJson();

        return $this->buildJsonResponse($jsonData);
    }

    /**
    * @Route("/cars/{id}", name="app_cars_car")
    * @Method({"GET"})
    */
   public function carAction($id)
   {
       $carsManager = $this->get('app.cars_manager');;
       $car = $carsManager->getCarJson($id);

       if($car === false){
         return $this->returnErrorMessage('Car not found',404);
       }else{
         return $this->buildJsonResponse($car);
       }
   }

   /**
   * @Route("/cars", name="app_cars_car_add")
   * @Method({"POST"})
   */
  public function carAddAction(Request $request)
  {
      $newCar = $request->request->all();

      $model = empty($newCar['model'])?'':$newCar['model'];
      $make = empty($newCar['make'])?'':$newCar['make'];
      $available = empty($newCar['available'])?false:true;
      $price = empty($newCar['price'])?'':$newCar['price'];
      $color = empty($newCar['color'])?'':$newCar['color'];

      $car = new Cars();

      $car->setModel($model)
      ->setMake($make)
      ->setPrice($price)
      ->setAvailable($available)
      ->setColor($color)
      ;
      
      $carsManager = $this->get('app.cars_manager');;

      if($carsManager->addCar($car) === false){
        return $this->returnErrorMessage('Failed to save',404);
      }else{
        return $this->buildJsonResponse("The car {$car->getId()} has been added");
      }
  }

   /**
   * @Route("/cars/delete/{id}", name="app_cars_car_delete")
   * @Method({"GET"})
   */
  public function deleteCarAction($id)
  {
      $carsManager = $this->get('app.cars_manager');;
      $cars = $carsManager->deleteCar($id);

      if($cars === false){
        return $this->returnErrorMessage('Car not found',404);
      }else{
        $message = ["success"=>"The car has been deleted"];
        $message = json_encode($message);
        return $this->buildJsonResponse($message);
      }
  }

   private function buildJsonResponse($message, $status = 200){
     $response = new Response();
     $response->setContent($message);
     $response->headers->set('Content-Type', 'application/json');

     return $response;
   }


   private function returnErrorMessage($message, $codeHTTP = 404){
     $responseError = ["error"=>$message];
     return new JsonResponse($responseError,$codeHTTP);
   }

}
