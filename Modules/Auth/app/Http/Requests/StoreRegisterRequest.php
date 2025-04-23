<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\app\DataTransferObjects\DoctorDto;

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
}
