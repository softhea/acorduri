<?php

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
            Artist::COLUMN_USER_ID => Auth::id(),
            Artist::COLUMN_IS_ACTIVE => $loggedUser->isAdmin(),
        ]);

        return [
            Artist::COLUMN_NAME => 'required|unique:' . Artist::TABLE . ',' . Artist::COLUMN_NAME,
            Artist::COLUMN_USER_ID => 'required',
            Artist::COLUMN_IS_ACTIVE => 'required',
        ];
    }
}
