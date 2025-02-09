<?php

declare(strict_types=1);

namespace App\Account\Domain\Service;

use App\Shared\Domain\ValueObject\Money;

interface FeeCalculatorInterface
{
    public function calculateFee(Money $money): Money;
}
