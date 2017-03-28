<?php
namespace PeterLeng\SpringSearch\Facades;

use Illuminate\Support\Facades\Facade;

class Elastic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'elastic';
    }
}