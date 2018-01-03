<?php namespace App\Api\Requester;

use Illuminate\Support\ServiceProvider;

class PeosApiServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('peosapi', function()
        {
            return new PeosApi();
        });
    }
}