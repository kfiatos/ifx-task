<?php

declare(strict_types=1);

namespace App\Payment\Application;

use App\Account\Application\TransferCommand;
use App\Account\Application\TransferHandler;
use App\Account\Domain\ValueObject\AccountId;
use App\AccountProviderInterface;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Infrastructure\PaymentRepositoryInterface;
use App\Shared\Domain\ValueObject\Currency;
use Ramsey\Uuid\Uuid;

class PayHandler
{
    public function __construct(
        private AccountProviderInterface $accountProvider,
        private TransferHandler $accountTransferHandler,
        private PaymentRepositoryInterface $paymentRepository
    ) {
    }

    public function __invoke(PayCommand $command): void
    {
        $payment = new Payment(
            new PaymentId(Uuid::uuid4()->toString()),
            $this->accountProvider->provide()->id,
            new AccountId($command->toAccount),
            $command->amount,
            new Currency($command->currency)
        );
        $this->paymentRepository->save($payment);

        $account = $this->accountProvider->provide();
        $transferCommand = new TransferCommand($account->id->toString(), $command->toAccount, $command->amount, $command->currency);
        // can be replaced with bus
        ($this->accountTransferHandler)($transferCommand);
    }
}
