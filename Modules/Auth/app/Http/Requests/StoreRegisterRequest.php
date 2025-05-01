<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Geo\app\ValueObjects\GeoPoint;

/**
 * @property mixed $password
 */
class StoreRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "email" => "required|string|email|unique:doctors",
            "password" => "required|string",
            "password_confirmation" => "required|string|same:password",
            "speciality" => "required|string",
            "latitude" => "nullable|string",
            "longitude" => "nullable|string",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getDoctorDto(): DoctorDto
    {
        return DoctorDto::fromArray($this->all());
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGeoPoint(): GeoPoint|null
    {
        if(isset($this->latitude) && isset($this->longitude)) {
            return new GeoPoint($this->latitude, $this->longitude);
        }

        return null;
    }
}
