<?php

declare(strict_types=1);

namespace App;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Exception\AccountNotFound;
use App\Account\Domain\ValueObject\AccountId;
use App\Account\Infrastructure\AccountRepositoryInterface;

class InMemoryAccountRepository implements AccountRepositoryInterface
{
    /**
     * @var Account[]
     */
    private array $accounts;

    public function save(Account $account): void
    {
        $this->accounts[$account->id->toString()] = $account;
    }

    public function get(AccountId $id): Account
    {
        if (\array_key_exists($id->toString(), $this->accounts)) {
            throw new AccountNotFound(\sprintf('Account id: %s not found', $id));
        }

        return $this->accounts[$id->toString()];
    }
}
