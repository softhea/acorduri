<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Artist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArtistRequest extends FormRequest
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
            Artist::COLUMN_NAME => [
                'required', 
                Rule::unique(Artist::TABLE, Artist::COLUMN_NAME)
                    ->ignore($this->route('artist')),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            Artist::COLUMN_NAME . '.required' => __('Name is required'),
            Artist::COLUMN_NAME . '.unique' => __('Name already exists'),
        ];
    }
}
