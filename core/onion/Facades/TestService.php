<?php
namespace Onion\Facades;

class TestService extends Facade {
    public static function getFacadeAccessor() {
        return 'testService';
    }
}