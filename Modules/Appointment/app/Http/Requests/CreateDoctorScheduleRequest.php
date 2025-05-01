<?php

namespace Modules\Appointment\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;

class CreateDoctorScheduleRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'week_day' => [
                'required',
                'in:'.implode(',',WeekDay::values()),
                Rule::unique('doctor_schedules')
                    ->where(function ($query) {
                        return $query->where('doctor_id', $this->doctor_id);
                    }),
            ],
        ];
    }



    public function authorize(): bool
    {
        return true;
    }

    public function getDto(): CreateDoctorScheduleDto
    {
        return CreateDoctorScheduleDto::fromArray(["week_day" => WeekDay::from($this->week_day), "doctor_id" => auth()->user()->id] + $this->all());
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'doctor_id' => auth()->user()->id
        ]);
    }
}
