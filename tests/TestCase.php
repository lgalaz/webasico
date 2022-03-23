<?php

namespace Tests;

use Throwable;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, ExtendsTraitSetup;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        // this is required if we want to use any application data in dataproviders.
        // this is because data providers are run before the setup method, and it is
        // in the setup method that laravel will create the application.

        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    protected function setUp() : void
    {
        parent::setUp();

        // https://adamwathan.me/2016/01/21/disabling-exception-handling-in-acceptance-tests/
        $this->disableExceptionHandling();
    }

    // https://adamwathan.me/2016/01/21/disabling-exception-handling-in-acceptance-tests/
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Throwable $e)
            {
            }

            public function render($request, Throwable $e)
            {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }
}
