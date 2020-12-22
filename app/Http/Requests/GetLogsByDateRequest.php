<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLogsByDateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['date'] = $this->route('date');
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date|date_format:Y-m-d H:i:s',
        ];
    }

}
