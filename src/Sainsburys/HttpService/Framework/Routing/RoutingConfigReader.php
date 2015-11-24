<?php
namespace Sainsburys\HttpService\Framework\Routing;

use Sainsburys\HttpService\Framework\FileWork\PhpArrayConfigFileReader;

class RoutingConfigReader
{
    /** @var PhpArrayConfigFileReader */
    private $phpArrayConfigFileReader;

    /**
     * @param PhpArrayConfigFileReader $phpArrayConfigFileReader
     */
    public function __construct(PhpArrayConfigFileReader $phpArrayConfigFileReader)
    {
        $this->phpArrayConfigFileReader = $phpArrayConfigFileReader;
    }

    /**
     * @param string $path
     * @return Route[]
     */
    public function getRoutesFromFile($path)
    {
        $fileContentsAsArray = $this->phpArrayConfigFileReader->readConfigFile($path);

        $routes = [];

        foreach ($fileContentsAsArray['routes'] as $name => $routeArray) {
            $routes[] = new Route($name, $routeArray);
        }

        return $routes;
    }
}