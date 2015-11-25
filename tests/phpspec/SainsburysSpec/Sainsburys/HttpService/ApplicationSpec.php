<?php
namespace SainsburysSpec\Sainsburys\HttpService;

use Sainsburys\HttpService\Components\ErrorHandling\ErrorControllerManager;
use Sainsburys\HttpService\Components\Middlewares\MiddlewareManager;
use Sainsburys\HttpService\Components\Routing\Route;
use Interop\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sainsburys\HttpService\Components\ErrorHandling\ErrorController;
use Sainsburys\HttpService\Components\Routing\RoutingConfigApplier;
use Sainsburys\HttpService\Components\Routing\RoutingConfigReader;
use Slim\App as SlimApplication;

class ApplicationSpec extends ObjectBehavior
{
    function let(
        SlimApplication        $slimApplication,
        RoutingConfigReader    $routingConfigReader,
        RoutingConfigApplier   $routingConfigApplier,
        ErrorControllerManager $errorControllerManager,
        MiddlewareManager      $middlewareManager
    ) {
        $this->beConstructedWith(
            $slimApplication, $routingConfigReader, $routingConfigApplier, $errorControllerManager, $middlewareManager
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sainsburys\HttpService\Application');
    }

    function it_can_be_set_up_with_a_container_and_routing_configs(
        ContainerInterface   $container,
        SlimApplication      $slimApplication,
        RoutingConfigReader  $routingConfigReader,
        RoutingConfigApplier $routingConfigApplier,
        Route                $route
    ) {
        // ARRANGE
        $routingConfigReader->getRoutesFromFile('config/routes.php')->willReturn([$route]);

        // ACT
        $this->takeContainerWithControllersConfigured($container);
        $this->takeRoutingConfigs(['config/routes.php']);

        // ASSERT
        $routingConfigApplier
            ->configureApplicationWithRoutes($slimApplication, [$route], $container)
            ->shouldHaveBeenCalled();
    }

    function it_can_run(
        ContainerInterface   $container,
        SlimApplication      $slimApplication,
        RoutingConfigReader  $routingConfigReader,
        Route                $route
    ) {
        // ARRANGE
        $routingConfigReader->getRoutesFromFile('config/routes.php')->willReturn([$route]);

        $this->takeContainerWithControllersConfigured($container);
        $this->takeRoutingConfigs(['config/routes.php']);

        // ACT
        $this->run();

        // ASSERT
        $slimApplication->run()->shouldHaveBeenCalled();
    }

    function it_lets_you_put_another_error_controller(
        ErrorController        $newErrorController,
        ErrorControllerManager $errorControllerManager
    ) {
        // ACT
        $this->useThisErrorController($newErrorController);

        // ASSERT
        $errorControllerManager->useThisErrorController($newErrorController)->shouldHaveBeenCalled();
    }

    function it_cant_run_without_routes()
    {
        $this->shouldThrow('\RuntimeException')->during('run');
    }

    function it_use_routes_without_a_container()
    {
        $this->shouldThrow('\RuntimeException')->during('takeRoutingConfigs', [['config/routes.php']]);
    }
}