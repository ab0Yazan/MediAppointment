<?php

namespace Modules\Appointment\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;

class CreateDoctorScheduleRequest extends FormRequest
{

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        Validator::make($this->all(), $this->rules());
    }

    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'week_day' => ['required', 'in:'.implode(',',WeekDay::values())],
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
}
