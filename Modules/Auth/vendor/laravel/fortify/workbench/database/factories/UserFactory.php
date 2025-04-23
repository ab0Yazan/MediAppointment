<?php

namespace Database\Factories;

use Modules\Auth\app\Models\Doctor;

/**
 * @template TModel of \Modules\Auth\app\Models\Doctor
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserFactory extends \Orchestra\Testbench\Factories\UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Doctor::class;
}
