<?php
namespace PeterLeng\SpringSearch;

use Illuminate\Support\Facades\Facade;

class Elastic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'elastic';
    }
}