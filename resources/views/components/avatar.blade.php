<div class="relative inline-block group">
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $name }}"
            class="{{ $getSizeClasses() }} rounded-full object-cover border-2 border-white shadow-sm hover:shadow-md transition-shadow"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        />
        <div
            class="{{ $getSizeClasses() }} {{ $getColorClass() }} rounded-full border-2 border-white shadow-sm hover:shadow-md transition-shadow hidden items-center justify-center text-white font-bold"
        >
            {{ $getInitials() }}
        </div>
    @else
        <div
            class="{{ $getSizeClasses() }} {{ $getColorClass() }} rounded-full border-2 border-white shadow-sm hover:shadow-md transition-shadow flex items-center justify-center text-white font-bold"
        >
            {{ $getInitials() }}
        </div>
    @endif

    @if($showOnlineStatus)
        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
    @endif
</div>

