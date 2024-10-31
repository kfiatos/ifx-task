<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final readonly class Currency
{
    public string $code;

    public function __construct(string $code)
    {
        $this->code = \mb_strtoupper($code);
    }

    public function equals(self $currency): bool
    {
        return $this->code === $currency->code;
    }
}
