<?php

namespace Controller;

class Controller
{
    //Variable Atrributes
    var $controllerName;
    var $controllerMethod;

    //Method untuk mengambil semua atribut
    public function getControllerAttribute()
    {
        return[
            "Controller Name" => $this->controllerName,
            "Method" => $this->controllerMethod,
        ]; 
    }
}