<?php

namespace App\Data;

use DateTimeInterface;

readonly class AssignMembershipData
{
    public function __construct(
        public int               $userId,
        public int               $planId,
        public string            $paymentMethod,
        public DateTimeInterface $startDate
    ) {}
}
