<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\VibeCheckService;
use Illuminate\Support\Facades\Auth;

class StoreVibeCheckRequest extends FormRequest
{
    public function authorize(): bool
    {
        $event = $this->route('event');
        $vibecheckService = app(VibeCheckService::class);
        
        return Auth::check() && $vibecheckService->canUserVibeCheck(Auth::user(), $event);
    }

    public function rules(): array
    {
        return [
            'sound_score'      => 'required|integer|min:1|max:5',
            'safe_space_score' => 'required|integer|min:1|max:5',
            'comment'          => 'required|string|max:1000',
        ];
    }
}