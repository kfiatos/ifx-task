<?php

declare(strict_types=1);

namespace App;

use App\Account\Domain\Entity\Transaction;
use App\Account\Domain\Exception\TransactionNotFound;
use App\Account\Infrastructure\TransactionRepositoryInterface;
use App\Shared\Domain\ValueObject\TransactionId;

class InMemoryTransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var Transaction[]
     */
    private array $transactions;

    public function save(Transaction $transaction): void
    {
        $this->transactions[$transaction->id->toString()] = $transaction;
    }

    public function get(TransactionId $id): Transaction
    {
        if (\array_key_exists($id->toString(), $this->transactions)) {
            throw new TransactionNotFound(\sprintf('Transaction id: %s not found', ${$id}));
        }

        return $this->transactions[$id->toString()];
    }
}
