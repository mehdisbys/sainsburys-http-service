<?php
namespace Ents\HttpMvcService\Framework\Controller;

use Ents\HttpMvcService\Framework\Controller\ControllerClosureBuilder\ErrorHandlingDecorator;
use Ents\HttpMvcService\Framework\Controller\ControllerClosureBuilder\ResponseTypeDecorator;
use Ents\HttpMvcService\Framework\Controller\ControllerClosureBuilder\SimpleControllerClosureBuilder;
use Ents\HttpMvcService\Framework\ErrorHandling\ErrorController;

class ControllerClosureBuilderFactory
{
    /**
     * Assemble object graph of ControllerClosureBuilder implementations (Decorator Pattern)
     *
     * @param ErrorController $errorController
     * @return ControllerClosureBuilder
     */
    public function getControllerClosureBuilder(ErrorController $errorController)
    {
        $closureBuilder = $this->getSimpleControllerClosureBuilder();
        $closureBuilder = $this->addResponseTypeChecking($closureBuilder);
        $closureBuilder = $this->addErrorChecking($closureBuilder, $errorController);

        return $closureBuilder;
    }

    /**
     * @return ControllerClosureBuilder
     */
    private function getSimpleControllerClosureBuilder()
    {
        return new SimpleControllerClosureBuilder();
    }

    /**
     * @param ControllerClosureBuilder $thingToDecorate
     * @return ControllerClosureBuilder
     */
    private function addResponseTypeChecking(ControllerClosureBuilder $thingToDecorate)
    {
        return new ResponseTypeDecorator($thingToDecorate);
    }

    /**
     * @param ControllerClosureBuilder $thingToDecorate
     * @param ErrorController          $errorController
     * @return ControllerClosureBuilder
     */
    private function addErrorChecking(ControllerClosureBuilder $thingToDecorate, ErrorController $errorController)
    {
        return new ErrorHandlingDecorator($thingToDecorate, $errorController);
    }
}