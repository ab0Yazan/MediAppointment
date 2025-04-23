<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Modules\Auth\app\Models\Doctor;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(Doctor $user, Team $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTeamName');

        $team->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
