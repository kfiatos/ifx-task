<?php

declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\Service\TransferService;
use App\Account\Domain\ValueObject\AccountId;
use App\Account\Infrastructure\AccountRepositoryInterface;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\Money;

readonly class TransferHandler
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private TransferService $moneyTransferService
    ) {
    }

    public function __invoke(TransferCommand $command): void
    {
        $debtorAccount = $this->accountRepository->get(new AccountId($command->from));
        $creditorAccount = $this->accountRepository->get(new AccountId($command->to));
        $this->moneyTransferService->transfer(
            $debtorAccount,
            $creditorAccount,
            new Money($command->amount, new Currency($command->currency))
        );

        $this->accountRepository->save($debtorAccount);
        $this->accountRepository->save($creditorAccount);
    }
}
