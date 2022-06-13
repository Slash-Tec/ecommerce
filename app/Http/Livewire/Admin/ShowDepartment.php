<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\Department;
use Livewire\Component;

class ShowDepartment extends Component
{
    public $department, $cities, $city;

    protected $listeners = ['delete'];

    public $createForm = [
        'name' => '',
        'cost' => null
    ];
    public $editForm = [
        'open' => false,
        'name' => '',
        'cost' => null
    ];
    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.cost' => 'costo'
    ];

    public function mount(Department $department){
        $this->department = $department;
        $this->getCities();
    }

    public function getCities(){
        $this->cities = City::where('department_id', $this->department->id)->get();
    }
    public function save(){
        $this->validate([
            "createForm.name" => 'required',
            "createForm.cost" => 'required|numeric|min:1|max:100',
        ]);
        $this->department->cities()->create($this->createForm);
        $this->reset('createForm');
        $this->getCities();
        $this->emit('saved');
    }
    public function edit(City $city){
        $this->city = $city;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $city->name;
        $this->editForm['cost'] = $city->cost;
    }
    public function update(){
        $this->city->name = $this->editForm['name'];
        $this->city->cost = $this->editForm['cost'];
        $this->city->save();
        $this->reset('editForm');
        $this->getCities();
    }
    public function delete(City $city){
        $city->delete();
        $this->getCities();
    }

    public function render()
    {
        return view('livewire.admin.show-department')->layout('layouts.admin');
    }
}
