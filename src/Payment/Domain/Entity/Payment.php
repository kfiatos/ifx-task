<?php

declare(strict_types=1);

namespace App\Payment\Domain\Entity;

use App\Account\Domain\ValueObject\AccountId;
use App\Payment\Domain\PaymentInterface;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\IdInterface;

readonly class Payment implements PaymentInterface
{
    private \DateTimeInterface $createdAt;

    public function __construct(
        public PaymentId $id,
        public AccountId $creditorAccount,
        public AccountId $debtorAccount,
        public int $amount,
        public Currency $currency
    ) {
        $this->createdAt = new \DateTime();
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getId(): IdInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
