<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Kreait\Firebase::class, function () {
            $serviceAccount = ServiceAccount::fromJsonFile('/Users/hayato/Desktop/Apps/instagram-like-app-5493e-firebase-adminsdk-21pf7-04b5a30df5.json');
            return (new Factory())
                ->withServiceAccount($serviceAccount)
                ->create();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return array
     */
    public function provides(): array
    {
        return [\Kreait\Firebase::class];
    }
}
