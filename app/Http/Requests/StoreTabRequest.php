<?php

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\Tab;
use App\Models\User;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        $this->merge([
            Tab::COLUMN_USER_ID => Auth::id(),
            Tab::COLUMN_IS_ACTIVE => $loggedUser->isActive(),
        ]);

        $exists = "";
        if (null !== $this->request->get('artist_id')) {
            $exists = "|exists:" . Artist::TABLE . "," . Artist::COLUMN_ID;
        }

        return [
            // todo per artist_id
            Tab::COLUMN_NAME => 'required|unique:' . Tab::TABLE . ',' . Tab::COLUMN_NAME, 
            Tab::COLUMN_ARTIST_ID => 'sometimes' . $exists,
            Tab::COLUMN_TEXT => 'required',
            Tab::COLUMN_IS_ACTIVE => 'required',
            Tab::COLUMN_USER_ID => 'required',
        ];
    }
}
