<?php
namespace Traits;

trait CanPay {
    public function pay($amount) {
        $formattedAmount = "Rp " . number_format($amount, 0, ',', '.');
        return "\n{$this->name} has paid {$formattedAmount}.";
    }
}
