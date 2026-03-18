<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        $event = $this->route('event');
        $user = $this->user();

        return $user->id === $event->user_id || $user->role->value === 'admin';
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:100',
            'lineup'        => 'required|string',
            'description'   => 'required|string',
            'date'          => 'required|date', 
            'start_time'    => 'required',
            'end_time'      => 'required',
            'price'         => 'required|numeric|min:0',
            'price_info'    => 'nullable|string|max:100', 
            'ticket_link'   => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Nullable en update
            'neighborhood'  => 'required|string|max:100',
            'genres'        => 'required|array|min:1', 
            'genres.*'      => 'exists:genres,id',
        ];
    }
}