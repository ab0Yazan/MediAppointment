<?php

namespace Modules\Appointment\app\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Appointment\app\Models\Slot;

class GenerateDoctorSlots extends Command
{
    protected $signature = 'slots:generate
                            {--months=1 : Number of months to generate slots for}
                            {--doctor= : Generate slots for specific doctor only}';

    protected $description = 'Generate available time slots for doctors based on their schedules';

    // Constants for better readability
    protected const SLOT_DURATION_MINUTES = 30;

    public function handle(): void
    {
        $this->generateSlotsForAllDoctors();
        $this->info('Slots generated successfully!');
    }

    protected function generateSlotsForAllDoctors(): void
    {
        $dateRange = $this->getDateRange();
        $schedules = $this->getDoctorSchedules();

        $this->displayGenerationInfo($dateRange, $schedules->count());

        $progressBar = $this->output->createProgressBar($schedules->count());
        $progressBar->start();

        foreach ($schedules as $schedule) {
            $this->generateSlotsForSchedule($schedule, $dateRange['start'], $dateRange['end']);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
    }

    protected function getDateRange(): array
    {
        return [
            'start' => now()->startOfDay(),
            'end' => now()->addMonths()->endOfDay()
        ];
    }

    protected function getDoctorSchedules(): Collection
    {
        $query = DoctorSchedule::with('doctor');

        if ($doctorId = $this->option('doctor')) {
            $query->where('doctor_id', $doctorId);
        }

        return $query->get();
    }

    protected function displayGenerationInfo(array $dateRange, int $scheduleCount): void
    {
        $this->info("Generating slots from {$dateRange['start']->toDateString()} " .
            "to {$dateRange['end']->toDateString()}");
        $this->info("Processing $scheduleCount doctor schedules");
    }

    protected function generateSlotsForSchedule(DoctorSchedule $schedule, Carbon $startDate, Carbon $endDate): void
    {
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            if ($this->isScheduledDay($currentDate, $schedule->week_day->value)) {
                $this->createDailySlots($schedule, $currentDate);
            }
            $currentDate->addDay();
        }
    }

    protected function isScheduledDay(Carbon $date, string $scheduledDay): bool
    {
        return strtolower($date->format('D')) === strtolower($scheduledDay);
    }

    protected function createDailySlots(DoctorSchedule $schedule, Carbon $date): void
    {
        $workingHours = $this->getDailyWorkingHours($schedule, $date);
        $slotStart = $workingHours['start'];
        $slotEnd = $workingHours['end']->addMinutes(static::SLOT_DURATION_MINUTES);

        while ($slotStart->addMinutes(self::SLOT_DURATION_MINUTES) <= $slotEnd) {
            $this->createSlot($schedule, $date, $slotStart);
        }
    }

    protected function getDailyWorkingHours(DoctorSchedule $schedule, Carbon $date): array
    {
        return [
            'start' => $date->copy()->setTimeFrom(Carbon::parse($schedule->start_time)),
            'end' => $date->copy()->setTimeFrom(Carbon::parse($schedule->end_time))
        ];
    }

    protected function createSlot(DoctorSchedule $schedule, Carbon $date, Carbon $slotEndTime): void
    {
        $slotStartTime = $slotEndTime->copy()->subMinutes(self::SLOT_DURATION_MINUTES);

        Slot::updateOrCreate(
            [
                'doctor_schedule_id' => $schedule->id,
                'date' => $date->toDateString(),
                'start_time' => $slotStartTime->toTimeString(),
                'end_time' => $slotEndTime->toTimeString(),
                'week_day' => $schedule->week_day->value,
            ],
            [

            ]
        );
    }
}
