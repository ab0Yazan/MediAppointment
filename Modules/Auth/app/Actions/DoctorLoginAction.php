<?php

namespace Modules\Auth\app\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\app\DataTransferObjects\LoginDto;
use Modules\Auth\app\Models\Doctor;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DoctorLoginAction
{
    public function execute(LoginDto $dto): array
    {
        $doctor = $this->validateCredentials($dto->getEmail(), $dto->getPassword());
        $p_token= $doctor->createToken('personal_access_token', ['*'], now()->addHour())->plainTextToken;
        $r_token= $doctor->createToken('refresh_token', ['refresh'], now()->addDay())->plainTextToken;
        return [
            'token' => $p_token,
            'token_type' => 'bearer',
            'personal_token_expires_in' => now()->addHour(),
            'refresh_token_expires_in' => now()->addDay(),
            'refresh_token' => $r_token,
            'user' => $doctor,
        ];
    }

    private function validateCredentials(string $email, string $password): Doctor
    {
        $doctor = Doctor::where('email', $email)->first();

        if (! $doctor || ! Hash::check($password, $doctor->password)) {
            throw new UnauthorizedHttpException('', 'Invalid email or password.');
        }

        return $doctor;
    }
}
