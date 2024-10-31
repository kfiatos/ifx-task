<?php

declare(strict_types=1);

namespace App\Account\Domain\Entity;

use App\Account\Domain\ValueObject\AccountId;
use App\Shared\Domain\ValueObject\TransactionId;

readonly class Transaction
{
    public \DateTimeInterface $transactionDate;

    public function __construct(public TransactionId $id, public AccountId $debit, public ?AccountId $credit, public int $amount)
    {
        $this->transactionDate = new \DateTimeImmutable();
    }
}
