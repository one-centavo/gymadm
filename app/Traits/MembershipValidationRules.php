<?php

namespace App\Traits;

use Illuminate\Validation\Rule;

trait MembershipValidationRules
{
	protected function userIdRules(): array
	{
		return [
			'required',
			'integer',
			Rule::exists('users', 'id')->where('role', 'member'),
		];
	}

	protected function membershipPlanIdRules(): array
	{
		return [
			'required',
			'integer',
			Rule::exists('membership_plans', 'id')->where('status', 'active'),
		];
	}

	protected function startDateRules(): array
	{
		return [
			'required',
			'date',
		];
	}

	protected function endDateRules(): array
	{
		return [
			'required',
			'date',
			'after_or_equal:start_date',
		];
	}

	protected function paymentMethodRules(): array
	{
		return [
			'required',
			'string',
			'max:30',
			Rule::in(['cash', 'transfer', 'card']),
		];
	}

	protected function cancellationReasonRules(): array
	{
		return [
			'nullable',
			'string',
		];
	}

	protected function cancelledAtRules(): array
	{
		return [
			'nullable',
			'date',
		];
	}

	protected function pricePaidRules(): array
	{
		return [
			'required',
			'numeric',
			'min:0',
			'max:9999999.99',
		];
	}
}
