<?php
namespace Ents\HttpMvcService\Dev\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\Http;

class SimpleController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function simpleAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getAttribute('id');

        return new JsonResponse(
            [
                'id' => $id,
                'name' => 'Eminem'
            ],
            Http::OK
        );
    }
}
