<?php

declare(strict_types=1);

namespace App\Account\Domain\Service;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Entity\Transaction;
use App\Shared\Domain\ValueObject\Currency;

class TransferRuleChecker
{
    public function __construct(private int $dailyLimit)
    {
    }

    public function checkCurrency(Currency $accountCurrency, Currency $transferCurrency): bool
    {
        return $accountCurrency->equals($transferCurrency);
    }

    /**
     * @param Transaction[] $transactions
     */
    public function checkTransactionsLimitForAccount(array $transactions, Account $account): bool
    {
        $count = 0;

        foreach ($transactions as $transaction) {
            if (!$transaction->debit->equals($account->id)) {
                continue;
            }

            if ($transaction->transactionDate->format('Y-m-d') === (new \DateTime())->format('Y-m-d')) {
                $count++;
            }

            if ($this->dailyLimit <= $count) {
                return false;
            }
        }

        return true;
    }
}
