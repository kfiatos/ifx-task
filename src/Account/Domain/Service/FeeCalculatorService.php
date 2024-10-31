<?php

declare(strict_types=1);

namespace App\Account\Domain\Service;

use App\Shared\Domain\ValueObject\Money;

class FeeCalculatorService implements FeeCalculatorInterface
{
    public function calculateFee(Money $money): Money
    {
        return new Money((int) \round(0.05 * $money->amount), $money->currency);
    }
}
