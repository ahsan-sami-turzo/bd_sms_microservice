<?php


namespace Radon\LaravelBDSms\Handler;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RenderException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function render(Request $request)
    {

    }
}
