<?php

declare(strict_types=1);

namespace App;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\ValueObject\AccountId;
use App\Shared\Domain\ValueObject\Currency;
use Ramsey\Uuid\Uuid;

class AccountProvider implements AccountProviderInterface
{
    public function provide(): Account
    {
        return new Account(
            new AccountId(Uuid::uuid4()->toString()),
            new Currency('GBP'),
            []
        );
    }
}
