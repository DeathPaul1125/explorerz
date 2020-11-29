<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Course;
use App\Models\Schedule;
use Livewire\Component;

class Create extends Component
{
    public $course;
    public $start;
    public $day;
    public $dimension;
    public $schedule;

    public function mount ($course){
        $this->schedule = $course->schedule;
    }


    public function create( $dim){
        $schedule = new Schedule;
        $schedule->day = $this->day;
        $schedule->start = $this->start;
        $schedule->dimension = $dim;
        $schedule->save();
        $schedule->courses()->sync($this->course);
        $course = Course::find($this->course->id);
        $this->schedule = $course->schedule;
    }
    public function render()
    {
        return view('livewire.schedule.create');
    }
}
