<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Departamento;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class FormData extends Component
{
    use WithFileUploads;
    public $hv;
    public $sex = 'male', $address, $phone, $eps, $size = 's', $age, $utc_nacimiento, $number_document, $type_document = "c.c", $full_name;
    public $id_departamento = 3, $municipio = 149;


    protected $rules = [
        'hv' => "required|mimes:pdf",
        'sex' => "required", 
        'address' => "required", 
        'phone' => "required", 
        'eps' => "required", 
        'size' => "required", 
        'age' => "required", 
        'utc_nacimiento' => "required", 
        'number_document' => "required", 
        'type_document' => "required", 
        'full_name' => "required",
    ];

    public function save()
    {
        // $this->dimensions = getimagesize($this->photo->path());
        $this->validate();
        $newname = Str::random(20);
        try {
            $this->hv->storeAs('hvs/'.auth()->user()->id,$newname.'.pdf');
            
            auth()->user()->usertable->full_name = $this->full_name;
            auth()->user()->usertable->type_document = $this->type_document;
            auth()->user()->usertable->number_document = $this->number_document;
            auth()->user()->usertable->utc_nacimiento = strtotime($this->utc_nacimiento);
            auth()->user()->usertable->age = $this->age;
            auth()->user()->usertable->sex = $this->sex;
            auth()->user()->usertable->eps = $this->eps;
            auth()->user()->usertable->address = $this->address;
            auth()->user()->usertable->departamento_id = $this->id_departamento;
            auth()->user()->usertable->municipio_id = $this->municipio;
            auth()->user()->usertable->phone = preg_replace('([^A-Za-z0-9])', '', $this->phone);
            auth()->user()->usertable->hv = $newname.'.pdf';
            auth()->user()->usertable->save();
            $this->reset(['hv']);

        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function render()
    {
        return view('livewire.teacher.form-data',[
            'departamentos' => Departamento::all(),
            'municipios' => Departamento::find($this->id_departamento)->municipio,
        ]);
    }
}
