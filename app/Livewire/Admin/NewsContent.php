<?php

namespace App\Livewire\Admin;

use App\Models\County;
use App\Models\Region;
use App\Models\Subcounty;
use Livewire\Component;

class NewsContent extends Component
{
    public $searchCounty = '';
    public $searchConstituency = '';
    public $searchSubcounty = '';

    public $counties = [];
    public $constituencies = [];
    public $subcounties = [];

    public function updatedSearchCounty()
    {
        $this->counties = !empty($this->searchCounty)
            ? County::where('name', 'like', '%' . $this->searchCounty . '%')->get()
            : [];

    }

    public function updatedSearchConstituency()
    {
        $this->constituencies = !empty($this->searchConstituency)
            ? Region::where('name', 'like', '%' . $this->searchConstituency . '%')->get()
            : [];
    }

    public function updatedSearchSubcounty()
    {
        $this->subcounties = !empty($this->searchSubcounty)
            ? Subcounty::where('name', 'like', '%' . $this->searchSubcounty . '%')->get()
            : [];
    }


    public function render()
    {
        return view('livewire.admin.news-content');
    }
}
