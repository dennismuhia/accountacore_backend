<?php

namespace App\Livewire\News;

use App\Models\County;
use App\Models\News;
use App\Models\Region;
use App\Models\Subcounty;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class WriteNews extends Component
{
    use WithFileUploads;

    public $searchCounty = '';
    public $selectedCounty = '';
    public $searchConstituency = '';
    public $selectedConstituency = '';
    public $searchSubcounty = '';
    public $selectedSubcounty = '';

    public $counties = [];
    public $constituencies = [];
    public $subcounties = [];
    public $selectedConstituencyId = '';
    public $newsType = '';
    public $title = '';
    public $content = '';
    public $image = null;
    public $selectedSubcountyId = '';
    public $selectedCountyId = '';

    // protected $listeners = [
    //     'quillContentUpdated' => 'updateContent',
    // ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required',
        'newsType' => 'required|in:national,local',
        'image' => 'nullable|image|max:2048',
        'selectedCountyId' => 'required_if:newsType,local',
    ];

    protected $messages = [
        'title.required' => 'The title field is required.',
        'content.required' => 'The content field is required.',
        'newsType.required' => 'Please select a news type.',
        'selectedCountyId.required_if' => 'Please select a county for local news.',
    ];

    public function updatedNewsType($value)
    {
        if ($value === 'national') {
            $this->reset([
                'selectedCountyId', 'selectedCounty',
                'selectedConstituencyId', 'selectedConstituency',
                'selectedSubcountyId', 'selectedSubcounty'
            ]);
        }
    }

    public function updatedSearchCounty()
    {
        if ($this->newsType === 'local') {
            $this->counties = County::where('name', 'like', '%' . $this->searchCounty . '%')
                                  ->limit(10)
                                  ->get();
        }
    }

    public function selectCounty($id, $name)
    {

        $this->selectedCountyId = $id;
        $this->selectedCounty = $name;
        $this->constituencies = Region::where('county_id', $id)->get();
        $this->counties = [];
        $this->searchCounty = '';
    }

    public function selectConstituency($id, $name)
    {
        $this->selectedConstituencyId = $id;
        $this->selectedConstituency = $name;
        $this->subcounties = Subcounty::where('region_id', $id)->get();
        $this->constituencies = [];
        $this->searchConstituency = '';
    }

    public function selectSubcounty($id, $name)
    {
        $this->selectedSubcountyId = $id;
        $this->selectedSubcounty = $name;
        $this->subcounties = [];
        $this->searchSubcounty = '';
    }

    // public function updateContent($value)
    // {
    //     $this->content = $value;
    // }

    public function createNews()
    {
        $this->validate();

        try {
            $news = new News();
            $news->title = $this->title;
            $news->content = $this->content;
            $news->type = $this->newsType;

            if ($this->newsType === 'local') {
                $news->county_id = $this->selectedCountyId;
                $news->region_id = $this->selectedConstituencyId;
                $news->subcounty_id = $this->selectedSubcountyId;
            }

            if ($this->image) {
                $news->image = $this->image->store('news_images', 'public');
            }

            $news->save();
            $this->resetFormFields();
            $this->resetExcept(['newsType']);

            session()->flash('success', 'News created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create news: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'title' => $this->title,
                'type' => $this->newsType,
                'county_id' => $this->selectedCountyId,
                'region_id' => $this->selectedConstituencyId,
                'subcounty_id' => $this->selectedSubcountyId,
            ]);

            session()->flash('error', 'There was an error creating the news. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.news.write-news');
    }
    public function resetFormFields()
{
    $this->searchCounty = '';
    $this->selectedCounty = '';
    $this->searchConstituency = '';
    $this->selectedConstituency = '';
    $this->searchSubcounty = '';
    $this->selectedSubcounty = '';

    $this->counties = [];
    $this->constituencies = [];
    $this->subcounties = [];

    $this->selectedConstituencyId = '';
    $this->newsType = '';
    $this->title = '';
    $this->content = '';
    $this->image = null;
    $this->selectedSubcountyId = '';
    $this->selectedCountyId = '';
}
}
