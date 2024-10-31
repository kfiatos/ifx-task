<?php

declare(strict_types=1);

namespace App\Account\Infrastructure;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Exception\AccountNotFound;
use App\Account\Domain\ValueObject\AccountId;

interface AccountRepositoryInterface
{
    public function save(Account $account): void;

    /**
     * @throws AccountNotFound
     */
    public function get(AccountId $id): Account;
}
