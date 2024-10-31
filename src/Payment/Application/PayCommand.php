<?php

declare(strict_types=1);

namespace App\Payment\Application;

readonly class PayCommand
{
    public function __construct(public string $toAccount, public int $amount, public string $currency)
    {
    }
}
