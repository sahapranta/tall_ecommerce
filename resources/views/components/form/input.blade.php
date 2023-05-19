@props(['disabled' => false, 'type'=>'text', 'name', 'label', 'placeholder'])
<div>
    <label for="{{$name}}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$label??$name}}</label>
    <input name="{{$name}}" placeholder="{{$placeholder??$name}}" {!! $attributes !!} {{ $disabled ? 'disabled' : '' }} type="{{$type}}" id="{{$name}}" wire:model.lazy="{{$name}}" class="form-input mt-1 block w-full rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 @error($name) border-red-500 @enderror" />
    @error($name)<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
</div>