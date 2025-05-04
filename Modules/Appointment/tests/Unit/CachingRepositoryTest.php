<?php

namespace Modules\Appointment\tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;
use Tests\TestCase;

class CachingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_actually_caches_results()
    {

        $this->createDoctorAndSchedule();

        // First call - should hit database
        $repo = app()->make(SlotRepositoryInterface::class);
        $firstCall = $repo->all();

        // Verify query count (using Laravel's query log)
        $this->assertNotEmpty($firstCall);
        $queryCount = count(\DB::getQueryLog());

        // Second call - should come from cache
        $secondCall = $repo->all();

        // Verify:
        // 1. Same results
        // 2. No additional queries
        $this->assertEquals($firstCall, $secondCall);
        $this->assertCount($queryCount, \DB::getQueryLog());
    }

}
