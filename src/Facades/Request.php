<?php namespace Radon\LaravelBDSms\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Radon\LaravelBDSms\Request get($requestUrl, array $query, bool $verify = false, $timeout = 10.0)
 * @method static Radon\LaravelBDSms\Request post($requestUrl, array $query, bool $verify = false, $timeout = 10.0)
 * @method static Radon\LaravelBDSms\Request setQueue(bool $queue)
 * @see \Radon\LaravelBDSms\Request
 */
class Request extends Facade
{
    /**
     * @return string
     * @version v1.0.36
     * @since v1.0.36
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSmsRequest';
    }
}
