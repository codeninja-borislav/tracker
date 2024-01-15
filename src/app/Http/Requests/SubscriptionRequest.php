<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CurrencyPair;
use App\Enums\NotificationType;
use App\Enums\TimeInterval;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'currency_pair' => ['required', Rule::in(CurrencyPair::values())],
            'notification_conditions' => 'required|array',
            'notification_conditions.*.type' => ['required', Rule::in(NotificationType::values())],
            'notification_conditions.*.value' => 'required|numeric',
            'notification_conditions.*.time_interval' => ['nullable', Rule::in(TimeInterval::values())],
        ];
    }
}
