<?php

namespace App\Livewire\Financials;

use App\Models\Financial;
use Livewire\Component;

class Finance extends Component
{
    public $newsId;
    public $financials = [];
    public $newsItem; // now you have the whole news object!

    protected $listeners = ['setNewsId' => 'setNewsId'];

    public function mount($newsItem)
    {
        $this->newsItem = $newsItem;
        $this->newsId = $newsItem->id;
        $this->financials = []; // Don't need to mount newsId here
    }

    public function setNewsId($id)
    {
        $this->newsId = $id;
        $this->financials = []; // reset when new news selected
        $this->addFinancial(); // start with one
    }

    public function addFinancial()
    {
        $this->financials[] = [
            'name' => '',
            'amount' => '',
            'description' => '',
        ];
    }

    public function save()
    {
        foreach ($this->financials as $financial) {
            Financial::create([
                'news_id' => $this->newsId,
                'name' => $financial['name'],
                'amount' => $financial['amount'],
                'description' => $financial['description'],
            ]);
        }

        session()->flash('message', 'Financial details saved successfully!');
        $this->financials = [];
    }
    public function render()
    {
        return view('livewire.financials.finance');
    }
}
