<?php

declare(strict_types=1);

namespace App\Account\Application;

class TransferCommand
{
    public function __construct(public string $from, public string $to, public int $amount, public string $currency)
    {
    }
}
