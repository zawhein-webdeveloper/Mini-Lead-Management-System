<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatedRequestForm extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $leadId = $this->route('lead')?->id ?? $this->route('lead');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('leads', 'email')->ignore($leadId)],
            'phone' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['new', 'in_progress', 'closed'])],
        ];
    }
}
