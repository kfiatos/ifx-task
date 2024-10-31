<?php

declare(strict_types=1);

namespace App\Account\Infrastructure;

use App\Account\Domain\Entity\Transaction;
use App\Shared\Domain\ValueObject\TransactionId;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction): void;

    public function get(TransactionId $id): Transaction;
}
