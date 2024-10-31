<?php

declare(strict_types=1);

namespace App\Account\Domain\Entity;

use App\Account\Domain\Exception\InsufficientAccountBalance;
use App\Account\Domain\ValueObject\AccountId;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\TransactionId;
use Ramsey\Uuid\Uuid;

class Account implements AccountInterface
{
    /**
     * @param AccountId $id
     * @param Currency $currency
     * @param Transaction[] $transactions
     */
    public function __construct(public AccountId $id, public Currency $currency, private array $transactions)
    {
    }

    public function sendTo(?self $to, int $amount): Transaction
    {
        $id = new TransactionId(Uuid::uuid4()->toString());
        $transaction = new Transaction($id, $this->id, $to?->id, $amount);

        if ($this->getBalance() >= $transaction->amount) {
            $this->transactions[] = $transaction;

            if (null !== $to) {
                $to->transactions[] = $transaction;
            }

            return $transaction;
        }

        throw new InsufficientAccountBalance();
    }

    public function getBalance(): int
    {
        $balance = 0;

        foreach ($this->transactions as $transaction) {
            if ($transaction->credit?->equals($this->id)) {
                $balance += $transaction->amount;
            }

            if ($transaction->debit->equals($this->id)) {
                $balance -= $transaction->amount;
            }
        }

        return $balance;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
