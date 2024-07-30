<?php

namespace App\Http\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = ['First'];

    protected $rules = [
          'title' => 'required|min:3|max:255',
          'options' => 'required|array|min:1|max:10',
          'options.*' => 'required|min:1|max:255'  
    ];

    protected $messages = [
        'title.required' => 'The poll title is required.',
        'title.min' => 'The poll title must be at least 3 characters.',
        'title.max' => 'The poll title may not be greater than 255 characters.',
        'options.required' => 'You must add at least one option.',
        'options.array' => 'Options must be an array.',
        'options.min' => 'You must add at least one option.',
        'options.max' => 'You can add a maximum of 10 options.',
        'options.*.required' => "The option can't be empty.",
        'options.*.min' => 'Each option must be at least 1 character.',
        'options.*.max' => 'Each option may not be greater than 255 characters.'
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }
    public function addOption()
    {
        $this->options[] = '';
    }
    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    //     if(isset($this->options[$index])){
    //     unset($this->options[$index]);
    //     $this->options = array_values($this->options);
    //     $this->options = array_merge([], $this->options);
    //     \Log::info("Option at index {$index} removed. Options are now:", $this->options);
    // }else{
    //     \Log::warning("Attempted to remove non-existent option at index {$index}");
    // }
        
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate($this->rules, $this->messages);

       Poll::create([
            'title' => $this->title
        ])->options()->createMany(
            collect($this->options)
            ->map(fn ($option) => ['name' => $option])
            ->all()
        );
       $this->reset(['title', 'options']);
       $this->emit('pollCreated');
    }
}