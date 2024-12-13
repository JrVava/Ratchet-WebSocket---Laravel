@if (!$isRead)
    <!-- Single Tick for Unread -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="gray">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
@else
    <div style="display: inline-grid;">
    <!-- Double Ticks for Read -->
    <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute;" class="h-3 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="blue">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-4 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="blue">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
</div>
@endif
