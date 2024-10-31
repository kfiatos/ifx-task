<?php

declare(strict_types=1);

namespace App;

use App\Account\Domain\Entity\Account;

interface AccountProviderInterface
{
    public function provide(): Account;
}
