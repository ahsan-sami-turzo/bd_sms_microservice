<?php namespace Radon\LaravelBDSms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Radon\LaravelBDSms\SMS via(string $provider)
 * @method static mixed shoot(string $mobile, string $text)
 * @method static mixed shootWithQueue(string $number, string $text)
 *
 * @see \Radon\LaravelBDSms\SMS
 */
class SMS extends Facade
{
    /**
     * @return string
     * @version v1.0.32
     * @since v1.0.31
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSms';
    }
}
