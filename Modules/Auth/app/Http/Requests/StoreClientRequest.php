<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\DataTransferObjects\ClientDto;

/**
 * @property mixed $password
 */
class StoreClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getClientDto(): ClientDto
    {
        return ClientDto::fromArray($this->all());
    }

    public function getName(): string
    {
        return $this->getClientDto()->getName();
    }

    public function getEmail(): string
    {
        return $this->getClientDto()->getEmail();
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
