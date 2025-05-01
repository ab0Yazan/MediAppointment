<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\app\DataTransferObjects\SearchNearestDoctorDto;

class SearchNearestDoctorRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "speciality" => "nullable|string",
            "longitude" => "required|float",
            "latitude" => "required|float",
        ];
    }


    public function authorize(): bool
    {
        return true;
    }

    public function getSearchNearestDoctorDto(): SearchNearestDoctorDto
    {
        return SearchNearestDoctorDto::fromArray($this->all());
    }


}
