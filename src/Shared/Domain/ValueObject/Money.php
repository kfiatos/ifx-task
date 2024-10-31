<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final readonly class Money
{
    public int $amount;

    public Currency $currency;

    public function __construct(int $amount, Currency $currency)
    {
        if (0 >= $amount) {
            throw new \InvalidArgumentException('Amount has to be positive value.');
        }
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function add(self $money): self
    {
        $this->assertSameCurrency($money);

        return new self($this->amount + $money->amount, $this->currency);
    }

    public function subtract(self $money): self
    {
        $this->assertSameCurrency($money);
        $newAmount = $this->amount - $money->amount;

        if (0 > $newAmount) {
            throw new \DomainException('Insufficient funds.');
        }

        return new self($newAmount, $this->currency);
    }

    private function assertSameCurrency(self $money): void
    {
        if (!$this->currency->equals($money->currency)) {
            throw new \InvalidArgumentException('Currency mismatch');
        }
    }
}
