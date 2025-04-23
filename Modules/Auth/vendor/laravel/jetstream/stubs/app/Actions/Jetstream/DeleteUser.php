<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;
use Modules\Auth\app\Models\Doctor;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(Doctor $user): void
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
