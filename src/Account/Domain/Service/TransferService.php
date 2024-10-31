<?php

declare(strict_types=1);

namespace App\Account\Domain\Service;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Exception\CurrencyMismatch;
use App\Account\Domain\Exception\InsufficientAccountBalance;
use App\Account\Domain\Exception\TransactionLimitReached;
use App\Shared\Domain\ValueObject\Money;

class TransferService
{
    public function __construct(
        private FeeCalculatorInterface $feeCalculator,
        private TransferRuleChecker $transferRuleChecker
    ) {
    }

    public function transfer(Account $debitAccount, Account $creditAccount, Money $money): void
    {
        if (!$this->transferRuleChecker->checkCurrency($debitAccount->currency, $money->currency)) {
            throw new CurrencyMismatch();
        }

        if (!$this->transferRuleChecker->checkCurrency($creditAccount->currency, $money->currency)) {
            throw new CurrencyMismatch();
        }

        $transactions = $debitAccount->getTransactions();

        if (!$this->transferRuleChecker->checkTransactionsLimitForAccount($transactions, $debitAccount)) {
            throw new TransactionLimitReached();
        }

        $feeAmount = $this->feeCalculator->calculateFee($money);

        if ($debitAccount->getBalance() < $money->add($feeAmount)->amount) {
            throw new InsufficientAccountBalance();
        }

        // for the sake of simplicity there should be fee account provided and money sent there
        $debitAccount->sendTo(null, $feeAmount->amount);
        $debitAccount->sendTo($creditAccount, $money->amount);
    }
}
