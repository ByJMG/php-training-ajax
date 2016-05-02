<?php
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class MicroKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
      $bundles = array(
          new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
          new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
          new AppBundle\AppBundle(),
      );


       return $bundles;
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->mount('/', $routes->import('@AppBundle/Controller', 'annotation'));
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', ['secret' => 'ySXAZWsUi2bYGdPMknfZ8LaXPwAT1CDa']);

        // register services
        $carsManagerService = $c->register('app.cars_manager', 'AppBundle\\Manager\\CarsManager');
        $carsManagerService->setArguments([$c->getParameter('kernel.root_dir').'/../web/data/cars.json']);
    }

}
