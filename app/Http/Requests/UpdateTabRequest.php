<?php

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\Tab;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        if (null !== $this->request->get('artist_id')) {
            $exists = "|exists:" . Artist::TABLE . "," . Artist::COLUMN_ID;
        }

        return [
            Tab::COLUMN_NAME => [
                'required',
                //todo per artist
                Rule::unique(Tab::TABLE, Tab::COLUMN_NAME)
                    ->ignore($this->route('tab')),
            ],
            Tab::COLUMN_ARTIST_ID => 'sometimes' . $exists,
            Tab::COLUMN_TEXT => 'required',
        ];
    }
}
