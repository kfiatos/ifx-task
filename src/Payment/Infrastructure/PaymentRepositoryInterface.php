<?php

declare(strict_types=1);

namespace App\Payment\Infrastructure;

use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\ValueObject\PaymentId;

interface PaymentRepositoryInterface
{
    public function save(Payment $payment): void;

    public function get(PaymentId $id): Payment;
}
