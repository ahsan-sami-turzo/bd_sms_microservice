<?php


namespace Radon\LaravelBDSms\Handler;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ParameterException
 * @package Radon\LaravelBDSmsLog\Handler
 * @version v1.0.20
 * @since v1.0.20
 */
class ValidationException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     * @version v1.0.20
     * @since v1.0.20
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     * @version v1.0.20
     * @since v1.0.20
     */
    public function render(Request $request)
    {

    }
}
