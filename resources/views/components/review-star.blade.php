@props(['review'=>0])
<div class="flex items-center">
    {{$prefix ?? ''}}
    <x-star-rating :review="$review" />
    {{$suffix ?? ''}}
</div>