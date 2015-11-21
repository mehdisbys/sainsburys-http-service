<?php
namespace Ents\HttpMvcService\Framework\Exception\WithStatusCode;

use Ents\HttpMvcService\Framework\Exception\ExceptionWithHttpStatus;

class NotFoundException extends \RuntimeException implements ExceptionWithHttpStatus
{
    /**
     * @param string|null     $message
     * @param int|null        $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Resource or endpoint not found.';
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return 404;
    }
}
