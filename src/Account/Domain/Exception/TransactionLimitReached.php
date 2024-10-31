<?php

declare(strict_types=1);

namespace App\Account\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class TransactionLimitReached extends DomainException
{
}
