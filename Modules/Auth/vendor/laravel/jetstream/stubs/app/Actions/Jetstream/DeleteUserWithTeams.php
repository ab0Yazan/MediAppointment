<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Modules\Auth\app\Models\Doctor;

class DeleteUser implements DeletesUsers
{
    /**
     * Create a new action instance.
     */
    public function __construct(protected DeletesTeams $deletesTeams)
    {
    }

    /**
     * Delete the given user.
     */
    public function delete(Doctor $user): void
    {
        DB::transaction(function () use ($user) {
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     */
    protected function deleteTeams(Doctor $user): void
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function (Team $team) {
            $this->deletesTeams->delete($team);
        });
    }
}
