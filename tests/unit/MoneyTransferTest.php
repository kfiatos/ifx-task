<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\Account\Domain\Entity\Account;
use App\Account\Domain\Entity\Transaction;
use App\Account\Domain\Exception\CurrencyMismatch;
use App\Account\Domain\Exception\InsufficientAccountBalance;
use App\Account\Domain\Exception\TransactionLimitReached;
use App\Account\Domain\Service\FeeCalculatorService;
use App\Account\Domain\Service\TransferRuleChecker;
use App\Account\Domain\Service\TransferService;
use App\Account\Domain\ValueObject\AccountId;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\Money;
use App\Shared\Domain\ValueObject\TransactionId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MoneyTransferTest extends TestCase
{
    public function testTransfer(): void
    {
        $debtorAccountId = new AccountId(Uuid::uuid4()->toString());
        $creditorAccountId = new AccountId(Uuid::uuid4()->toString());

        $debtorAccount = new Account($debtorAccountId, new Currency('GBP'), [
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), new AccountId(Uuid::uuid4()->toString()), $debtorAccountId, 1000),
        ]);
        $creditorAccount = new Account($creditorAccountId, new Currency('GBP'), []);

        $transferService = new TransferService(new FeeCalculatorService(), new TransferRuleChecker(dailyLimit: 3));

        $transferService->transfer($debtorAccount, $creditorAccount, new Money(100, new Currency('GBP')));

        $this->assertEquals(100, $creditorAccount->getBalance());
        $this->assertEquals(895, $debtorAccount->getBalance());
    }

    public function testTransferNotPossibleWhenExceededTransactionsDaily(): void
    {
        $debtorAccountId = new AccountId(Uuid::uuid4()->toString());
        $creditorAccountId = new AccountId(Uuid::uuid4()->toString());

        $debtorAccount = new Account($debtorAccountId, new Currency('GBP'), [
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), new AccountId(Uuid::uuid4()->toString()), $debtorAccountId, 1000),
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), $debtorAccountId, new AccountId(Uuid::uuid4()->toString()), 100),
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), $debtorAccountId, new AccountId(Uuid::uuid4()->toString()), 100),
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), $debtorAccountId, new AccountId(Uuid::uuid4()->toString()), 100),
        ]);

        $creditorAccount = new Account($creditorAccountId, new Currency('GBP'), []);

        $transferService = new TransferService(new FeeCalculatorService(), new TransferRuleChecker(dailyLimit: 3));

        $this->expectException(TransactionLimitReached::class);
        $transferService->transfer($debtorAccount, $creditorAccount, new Money(100, new Currency('GBP')));
    }

    public function testTransferForWrongCurrency(): void
    {
        $debtorAccountId = new AccountId(Uuid::uuid4()->toString());
        $creditorAccountId = new AccountId(Uuid::uuid4()->toString());

        $debtorAccount = new Account($debtorAccountId, new Currency('GBP'), [
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), new AccountId(Uuid::uuid4()->toString()), $debtorAccountId, 1000),
        ]);
        $creditorAccount = new Account($creditorAccountId, new Currency('GBP'), []);

        $transferService = new TransferService(new FeeCalculatorService(), new TransferRuleChecker(dailyLimit: 3));

        $this->expectException(CurrencyMismatch::class);
        $transferService->transfer($debtorAccount, $creditorAccount, new Money(100, new Currency('EUR')));
    }

    public function testTransferForBalance(): void
    {
        $debtorAccountId = new AccountId(Uuid::uuid4()->toString());
        $creditorAccountId = new AccountId(Uuid::uuid4()->toString());

        $debtorAccount = new Account($debtorAccountId, new Currency('GBP'), [
            new Transaction(new TransactionId(Uuid::uuid4()->toString()), new AccountId(Uuid::uuid4()->toString()), $debtorAccountId, 1000),
        ]);
        $creditorAccount = new Account($creditorAccountId, new Currency('GBP'), []);

        $transferService = new TransferService(new FeeCalculatorService(), new TransferRuleChecker(dailyLimit: 3));

        $this->expectException(InsufficientAccountBalance::class);
        $transferService->transfer($debtorAccount, $creditorAccount, new Money(1000, new Currency('GBP')));
    }
}
