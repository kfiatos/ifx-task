<?php

declare(strict_types=1);

namespace App\Account\Domain\Entity;

use App\Shared\Domain\ValueObject\Currency;

interface AccountInterface
{
    public function getCurrency(): Currency;
}
