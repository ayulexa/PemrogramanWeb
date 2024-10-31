<?php
namespace Models;

use Traits\CanPay;

class Customer extends User {
    use CanPay;

    private $membershipLevel;

    public function __construct($name, $email, $membershipLevel) {
        parent::__construct($name, $email);
        $this->membershipLevel = $membershipLevel;
    }

    public function getUserInfo() {
        return "Customer - Name: {$this->name}, Email: {$this->email}, Membership: {$this->membershipLevel}.";
    }

    public function __toString() {
        return $this->getUserInfo();
    }
}
