<?php

namespace App\Services;

use App\Models\MembershipPlan;
use Illuminate\Pagination\LengthAwarePaginator;

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
     *     description?: string|null,
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

    public function getPlanStats(): array
    {
        $queryBase = $this->planModel->query();

        return [
            'total' => (clone $queryBase)->count(),
            'active' => (clone $queryBase)->where('status', 'active')->count(),
            'inactive' => (clone $queryBase)->where('status', 'inactive')->count(),
        ];
    }
    public function getPlanList(string $search = '', string $statusFilter = 'all'): LengthAwarePaginator
    {
        $query = $this->planModel->query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if (in_array($statusFilter, ['active', 'inactive'], true)) {
            $query->where('status', $statusFilter);
        }

        return $query->latest()->paginate(10);
    }

    public function updatePlan(int $id, array $data) : void
    {
        $this->planModel->where('id', $id)->update([
            'name'           => $data['name'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'],
            'duration_value' => $data['duration_value'],
            'duration_unit'  => $data['duration_unit']
        ]);
    }

    public function getPlanInfoById(int $id) : ?MembershipPlan
    {
        return $this->planModel->findOrFail($id);
    }
}
