<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class Identifier implements IdInterface
{
    private UuidInterface $value;

    public function __construct(string $id)
    {
        $this->value = Uuid::fromString($id);
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }

    public function equals(IdInterface $id): bool
    {
        return $id instanceof self && $this->value->equals($id->value);
    }

    public function toString(): string
    {
        return $this->value->toString();
    }
}
