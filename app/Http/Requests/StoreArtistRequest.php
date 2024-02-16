<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return array_merge(
            $this->request->all(), 
            [
                Artist::COLUMN_USER_ID => (int) Auth::id(),
            ]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Artist::COLUMN_NAME => 'required|unique:' . Artist::TABLE . ',' . Artist::COLUMN_NAME,
            Artist::COLUMN_USER_ID => 'sometimes|exists:' . User::TABLE . ',' . User::PRIMARY_KEY, 
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
            Artist::COLUMN_USER_ID . '.exists' => __('User not found'),
        ];
    }
}
