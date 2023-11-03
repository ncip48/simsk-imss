<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use FPDI\PdfParser\PdfParser;
use FPDI\PdfParser\StreamReader;
use FPDI\PdfReader\PdfReader;

class FpdiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('FPDI\PdfParser\PdfParser', function ($app) {
            return new PdfParser(new StreamReader());
        });

        $this->app->singleton('FPDI\PdfReader\PdfReader', function ($app) {
            return new PdfReader();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
