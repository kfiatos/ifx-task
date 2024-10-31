<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface IdInterface
{
    public function __toString(): string;

    public function toString(): string;

    public function equals(self $id): bool;
}
