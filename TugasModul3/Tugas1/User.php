<?php
namespace Models;

abstract class User {
    protected $name;
    protected $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    abstract public function getUserInfo();
}
