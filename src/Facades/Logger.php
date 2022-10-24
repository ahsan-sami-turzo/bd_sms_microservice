<?php namespace Radon\LaravelBDSms\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Radon\LaravelBDSms\Log\Log createLog(array $data)
 * @method static Radon\LaravelBDSms\Log\Log viewLastLog()
 * @method static Radon\LaravelBDSms\Log\Log viewAllLog()
 * @method static Radon\LaravelBDSms\Log\Log logByProvider()
 * @method static Radon\LaravelBDSms\Log\Log logByDefaultProvider()
 * @method static Radon\LaravelBDSms\Log\Log total()
 * @method static Radon\LaravelBDSms\Log\Log toArray()
 * @method static Radon\LaravelBDSms\Log\Log toJson()
 *
 * @see \Radon\LaravelBDSms\Log\Log
 */
class Logger extends Facade
{
    /**
     * @return string
     * @version v1.0.35
     * @since v1.0.35
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSmsLogger';
    }
}
