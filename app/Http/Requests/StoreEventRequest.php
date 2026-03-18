<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:100',
            'lineup'        => 'required|string',
            'description'   => 'required|string',
            'date'          => 'required|date|after_or_equal:today', 
            'start_time'    => 'required',
            'end_time'      => 'required',
            'price'         => 'required|numeric|min:0',
            'price_info'    => 'nullable|string|max:100', 
            'ticket_link'   => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'neighborhood'  => 'required|string|max:100',
            'genres'        => 'required|array|min:1', 
            'genres.*'      => 'exists:genres,id',
        ];
    }
}