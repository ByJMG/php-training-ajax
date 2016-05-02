<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\CarsController::indexAction',  '_route' => 'homepage',);
        }

        // app_cars_load_fixtures
        if ($pathinfo === '/load-cars-fixtures') {
            return array (  '_controller' => 'AppBundle\\Controller\\CarsController::loadCarsFixturesAction',  '_route' => 'app_cars_load_fixtures',);
        }

        if (0 === strpos($pathinfo, '/cars')) {
            // app_cars_list
            if ($pathinfo === '/cars') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_cars_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CarsController::carsAction',  '_route' => 'app_cars_list',);
            }
            not_app_cars_list:

            // app_cars_car
            if (preg_match('#^/cars/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_cars_car;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_cars_car')), array (  '_controller' => 'AppBundle\\Controller\\CarsController::carAction',));
            }
            not_app_cars_car:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
