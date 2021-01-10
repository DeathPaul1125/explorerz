<?php

namespace App\Http\Livewire\Course;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Model_course;
use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;


    public $allcourses = [];
    public $color = '#3B82F6';
    public $models;
    public $model = 1;
    public $show= 'all';
    public $course;
    public $active = '';
    public $today, $utc_inicial, $utc_final,$show_init = null;
    public $schedule, $create_activity = false, $activity_day, $material = [], $title, $description, $start, $end, $tasks = [];
    public $show_activity = false;
    public $id_activity = '',$activity;

    protected $queryString = [
        "show"=>['except'=>''],
        "active"=>['except'=>''],
        "show_init", 
        'show_activity',
        "id_activity" => ['except'=>''],
        'create_activity'
    ];
    protected $listeners = ['show_course'];



    public function mount(){
        switch (auth()->user()->roles[0]->id) {
            case 1:
                $this->allcourses = Course::all();
                break;
            case 2:
            case 3:
            case 4:
                $this->allcourses = auth()->user()->courses;
                break;
        }
        $this->models = Model_course::all();

        if($this->active != ''){
            $this->course = Course::find($this->active);
        }else{
            $this->show = 'all';
        }
        
        $this->today = time();
        $this->utc_inicial = $this->today-(date('N')*86400)-((date('G')*3600)+(date('i')*60)+date('s'));
        $this->utc_final = $this->utc_inicial+604800;
        if ($this->show_init == null) {
            $this->show_init = $this->utc_inicial;
        }
        // dd(count(Activity::find($this->id_activity)));
        if ($this->id_activity != '' && count(Activity::Where('id',$this->id_activity)->get()) == 1) {
            $this->activity = Activity::find($this->id_activity);
        }

    }
    public function create(){

            $course = new Course();
            $course->model_id = $this->model;
            $course->color = $this->color;
            $course->save();

            $course->users()->attach(auth()->user()->id);
            $this->allcourses = auth()->user()->courses;
    }
    public function dimension_name($id)
    {        
        switch($id){
            case  1: return 'Corporal'; break;
            case  2: return 'Cognitiva'; break;
            case  3: return 'Comunicativa'; break;
            case  4: return 'Etica'; break;
            case  5: return 'Estetica'; break;
            case  6: return 'Actitudinal'; break;
            case  7: return 'Valorativa'; break;
            case  8: return 'Matemáticas'; break;
            case  9: return 'Humanidades'; break;
            case  10: return 'Ciencias Naturales';  break;
            case  11: return 'Ciencias Sociales';  break;
            case  12: return 'Educación Artística';  break;
            case  13: return 'Educación Etica';  break;
            case  14: return 'Educación Fisica';  break;
            case  15: return 'Educación Religiosa';  break;
            case  16: return 'Tecnologia e informatica';  break;
            case  17: return 'Ciencias Politicas';  break;
            case  18: return 'Filosofia'; break;
        }
    }
    public function hour($hour){
        if ($hour < 12) {
            return $hour.' a.m';
        }
        if ($hour == 12) {
            return $hour.' m';
        }
        if ($hour > 12) {
            return ($hour-12).' p.m';
        }
    }

    public function show_course($course){
        $this->course = Course::find($course);
        $this->active = $course;
        $this->show = 'course';
    }
    public function all(){
        $this->show = 'all';
        $this->active = '';
    }
    public function view_activity(Activity $activity){
        $this->show_activity = true;
        $this->activity = $activity;
        $this->id_activity = $activity->id;
    }
    public function activity_agree(Schedule $schedule, $day){
        $this->create_activity = true;
        $this->schedule = $schedule;
        $this->activity_day = $day;
        //2021-01-04T19:44
        $start = $day+($schedule->start*3600);
        $this->start = date('Y-m-d',$start).'T'.date('H:i',$start);
        $this->end = date('Y-m-d',($start+3600)).'T'.date('H:i',($start+3600));
    }
    public function agg_material(){
        // $item = count($this->material);
        // $this->material[$item]['url'] = '';
        array_push($this->material, ['url' => null,'file' => null, 'description'=>null]);
    }
    public function remove_material($pos){
        unset($this->material[$pos]);
    }
    public function agg_tasks(){
        array_push($this->tasks, ['work' => null,'file' => 'yes','evaluate' => 'yes','points' => 5]);
    }
    public function cancel_activity(){
        $this->create_activity = false;
        $this->reset(['schedule','activity_day','title','description','start','end']);
        $this->material = [];
        $this->tasks = [];
    }
    public function activity_store(){
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        try {
            $day = $this->activity_day+($this->schedule->start*3600);
            $activity = Activity::create([
                'name' => $this->title,
                'description' => $this->description,
                'utc_inicial' => strtotime($this->start),
                'utc_final' => strtotime($this->end),
                'day' => $day
            ]);
            $this->schedule->activities()->attach($activity);
            $this->cancel_activity();
            
        } catch (\Throwable $th) {
            dd($th);
        }

    }
    public function render()
    {
        return view('livewire.course.create',[
            'materials' => $this->material
        ]);
    }
}
