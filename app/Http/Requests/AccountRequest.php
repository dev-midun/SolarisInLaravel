<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Support\Arr;

class AccountRequest extends BaseFormRequest
{
    public function rules(): array
    {
        if($this->routeIs('account.update.avatar')) {
            return [
                'profile_picture' => $this->pictureValidation()
            ];
        }

        $rules = match ($this->method()) {
            'POST' => $this->createRules(),
            'PUT' => $this->updateRules()
        };

        return $rules;
    }

    protected function createRules(): array
    {
        return [
            'profile_picture' => $this->pictureValidation(),
            'name' => 'required|string|max:255',
            'type_id' => 'required|uuid',
            // 'primary_contact_id' => 'nullable|uuid',
            'primary_phone' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
            'website' => 'nullable|string|max:255',
            'currency_id' => 'nullable|uuid',
            'industry_id' => 'required|uuid'
        ];
    }

    protected function updateRules(): array
    {
        return array_merge(Arr::except($this->createRules(), 'profile_picture'), [
            'npwp' => 'nullable|string|max:16',
            'customer_journey_id' => 'nullable|uuid',
            'also_known_as' => 'nullable|string|max:255',
            'group_company' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'segmentation_id' => 'nullable|uuid',
            'recency_date' => 'nullable|date_format:Y-m-d',
            'frequency' => [
                'nullable', 'integer', 
                function (string $attribute, mixed $value, Closure $fail) {
                    $frequencyType = $this->input('frequency_type_id');
                    if(!is_null($frequencyType) && (int)$value <= 0) {
                        $fail("Frequency is required");
                    }
                },
            ],
            'frequency_type_id' => [
                'nullable', 'uuid',
                function (string $attribute, mixed $value, Closure $fail) {
                    $frequency = $this->input('frequency');
                    if(is_null($value) && $frequency > 0) {
                        $fail("Frequency type is required");
                    }
                },
            ],
            'currency_id' => 'nullable|uuid',
            'monetary' => 'nullable|decimal:0,2',
            'business_size_id' => 'nullable|uuid',
            'ownership_type_id' => 'nullable|uuid',
            'annual_revenue_id' => 'nullable|uuid',
            'business_entity_id' => 'nullable|uuid',
            'industry_id' => 'nullable|uuid',
            'notes' => 'nullable|string'
        ]);
    }
}