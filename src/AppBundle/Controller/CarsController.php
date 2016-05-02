<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\DataFixtures\LoadCarsData;
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
        $jsonFile = $this->getJsonFilePath();
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

        $response = new Response();
        $response->setContent($jsonData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
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
         $response = new Response();
         $response->setContent($car);
         $response->headers->set('Content-Type', 'application/json');

         return $response;
       }

   }


   private function returnErrorMessage($message, $codeHTTP = 404){
     $responseError = ["error"=>$message];
     return new JsonResponse($responseError,$codeHTTP);
   }

}
