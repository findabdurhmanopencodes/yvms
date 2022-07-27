<?php

namespace App\Http\Requests;

use App\Models\CindicationRoom;
use App\Models\Volunteer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreCindicationRoomRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $trainingCenter = request()->route('training_center');
        $usedQuota = CindicationRoom::where('training_session_id', request()->route('training_session')->id)->where('trainining_center_id', $trainingCenter->id)->sum('number_of_volunteers');
        $totalVolunteers = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenter->id)->count();
        $availableQuota = $totalVolunteers - $usedQuota;
        if($availableQuota <=0){
            throw ValidationException::withMessages(['number_of_volunteers'=>'Reached maximum placement']);
        }
        return [
            'number' => 'required|unique:cindication_rooms,number',
            'number_of_volunteers' => ['required', 'numeric', 'min:1', 'max:' . ($availableQuota)],
        ];
    }
}
