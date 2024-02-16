<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\Tab;
use App\Rules\UniqueTableNamePerArtistIdExceptId;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTabRequest extends FormRequest
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
        $exists = "";
        $artistId = null;
        if (null !== $this->request->get('artist_id')) {
            $exists = "|exists:" . Artist::TABLE . "," . Artist::COLUMN_ID;
            $artistId = (int) $this->request->get('artist_id');
        }

        /** @var Tab $tab */
        $tab = $this->route('tab');

        return [
            Tab::COLUMN_NAME => [
                'required',
                (new UniqueTableNamePerArtistIdExceptId)
                    ->setId($tab->getId())
                    ->setArtistId($artistId)
            ],
            Tab::COLUMN_ARTIST_ID => 'sometimes' . $exists,
            Tab::COLUMN_TEXT => 'required',
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
        ];
    }
}
