<?php

namespace App\Services;

use App\Models\MembershipPlan;

class PlanService
{
    protected MembershipPlan $planModel;

    public function __construct(MembershipPlan $planModel)
    {
        $this->planModel = $planModel;
    }

    /**
     * @param array{
     *     name: string,
     *     description: string,
     *     price: mixed,
     *     duration_value: int|string,
     *     duration_unit: string
     * } $data
     */
    public function createPlan(array $data) : MembershipPlan
    {
        return $this->planModel->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration_value' => $data['duration_value'],
            'duration_unit' => $data['duration_unit'],
            'status' => 'active',
        ]);
    }

    public function isNameAvailable(string $name, int $excludeId = null) : bool
    {
        $query = $this->planModel::where('name', $name);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }
}
