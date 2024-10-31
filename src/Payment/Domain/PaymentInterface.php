<?php

declare(strict_types=1);

namespace App\Payment\Domain;

use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\IdInterface;

interface PaymentInterface
{
    public function getId(): IdInterface;

    public function getCurrency(): Currency;

    public function getAmount(): int;
}
