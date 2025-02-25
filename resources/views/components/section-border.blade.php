@props(['hide' => true])
<div class="sm:block {{ $hide ? 'hidden' : '' }}">
    <div class="{{ $hide ? 'py-8' : 'py-2' }}">
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
    </div>
</div>
