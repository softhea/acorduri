<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\Tab;
use App\Models\User;
use App\Rules\UniqueTableNamePerArtistId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTabRequest extends FormRequest
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
                Tab::COLUMN_USER_ID => (int) Auth::id(),
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
        $exists = "";
        $artistId = null;
        if (null !== $this->request->get('artist_id')) {
            $exists = "|exists:" . Artist::TABLE . "," . Artist::COLUMN_ID;
            $artistId = (int) $this->request->get('artist_id');
        }

        return [
            Tab::COLUMN_ARTIST_ID => 'sometimes' . $exists,
            Tab::COLUMN_NAME => [
                'required',
                (new UniqueTableNamePerArtistId)->setArtistId($artistId)
            ],
            Tab::COLUMN_TEXT => 'required',
            Tab::COLUMN_USER_ID => "required|exists:" . User::TABLE . "," . User::PRIMARY_KEY,
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
            Tab::COLUMN_ARTIST_ID . '.exists' => __('Artist not found'),
            Tab::COLUMN_NAME . '.required' => __('Name is required'),
            Tab::COLUMN_TEXT . '.required' => __('Tab is required'),            
            Tab::COLUMN_USER_ID . '.required' => __('User is required'),
            Tab::COLUMN_USER_ID . '.exists' => __('User not found'),
        ];
    }
}
