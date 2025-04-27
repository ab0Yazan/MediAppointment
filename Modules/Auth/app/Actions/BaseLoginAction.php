<?php

namespace Modules\Auth\Actions;


use Illuminate\Support\Facades\Hash;
use Modules\Auth\app\DataTransferObjects\LoginDto;
use Modules\Auth\app\Models\Doctor;
use Modules\Auth\Contracts\LoginActionInterface;
use Modules\Auth\Models\Client;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class BaseLoginAction implements LoginActionInterface
{
    abstract protected function getUserModel(): string;

    public function execute(LoginDto $dto) : array
    {
        $user= $this->validateCredentials($dto->getEmail(), $dto->getPassword());
        $p_token = $user->createToken('personal_access_token', ['*'], now()->addHour())->plainTextToken;
        $r_token = $user->createToken('refresh_token', ['refresh'], now()->addDay())->plainTextToken;

        return [
            'token' => $p_token,
            'token_type' => 'bearer',
            'personal_token_expires_in' => now()->addHour(),
            'refresh_token_expires_in' => now()->addDay(),
            'refresh_token' => $r_token,
            'user' => $user,
        ];

    }

    private function validateCredentials(string $email, string $password): Client|Doctor
    {
        $model = $this->getUserModel();
        $user = $model::where('email', $email)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid email or password.');
        }

        return $user;
    }
}
