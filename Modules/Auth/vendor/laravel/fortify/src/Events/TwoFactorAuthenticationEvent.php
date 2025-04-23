<?php

namespace Laravel\Fortify\Events;

use Illuminate\Foundation\Events\Dispatchable;

abstract class TwoFactorAuthenticationEvent
{
    use Dispatchable;

    /**
     * The user instance.
     *
     * @var \Modules\Auth\app\Models\Doctor
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Auth\app\Models\Doctor  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
