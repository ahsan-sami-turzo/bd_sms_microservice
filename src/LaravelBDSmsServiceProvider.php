<?php


namespace Radon\LaravelBDSms;

use Illuminate\Support\ServiceProvider;
use Radon\LaravelBDSms\Log\Log;

class LaravelBDSmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @version v1.0.32
     * @since v1.0.31
     */
    public function register()
    {
        $this->app->bind('LaravelBDSms', function () {

            $provider = config('sms.default_provider');

            $sender = Sender::getInstance();
            $sender->setProvider($provider);
            $sender->setConfig(config('sms.providers')[$provider]);
            return new SMS($sender);
        });

        $this->app->bind('LaravelBDSmsLogger', function () {
            return new Log;
        });

        $this->app->bind('LaravelBDSmsRequest', function () {
            return new Request;
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @version v1.0.32
     * @since v1.0.31
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/Config/sms.php' => config_path('sms.php'),
        ]);

        if ($this->app->runningInConsole() && !class_exists('CreateLaravelbdSmsTable')) {

            $this->publishes([
                __DIR__ . '/Database/migrations/create_laravelbd_sms_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_laravelbd_sms_table.php'),

            ], 'migrations');
        }
    }

}
