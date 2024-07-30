<div>
    <form wire:submit.prevent="createPoll">
        <label>Poll Title</label>

        <input type="text" wire:model="title" />
        @error('title')
            <div class="text-red-500">{{$message}}</div>
        @enderror
        Current title: {{$title}}
    <div  class="mb-4 mt-4" >
        <button class="btn" wire:click.prevent="addOption">Add Option</button>
        <div >
            @foreach($options as $index => $option)
                <div class=" mt-4">
                    <label>
                        Option{{ $index + 1 }}
                    </label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="options.{{ $index }}"/>
                        @error("options.{$index}")
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                        <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <button type="submit" class="btn">Create Poll</button>
    </form>
</div>
