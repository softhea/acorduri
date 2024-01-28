<?php

namespace App\Http\Requests;

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
        // $this->merge([
        //     'user_id' => Auth::id(),
        //     'is_active' => Auth::user()->role_id <= 2,
        // ]);

        $exists = "";
        if (null !== $this->request->get('artist_id')) {
            $exists = "|exists:artists,id";
        }

        return [
            'name' => [
                'required',
                Rule::unique('tabs', 'name')->ignore($this->route('tab')),
                //todo per artist
            ],
            'artist_id' => 'sometimes' . $exists,
            'text' => 'required',
            // 'is_active' => 'required',
            // 'user_id' => 'required',
        ];
    }
}
