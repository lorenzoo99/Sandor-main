@props(['title', 'value', 'icon' => null, 'trend' => null, 'trendValue' => null, 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'purple' => 'bg-purple-500',
        'indigo' => 'bg-indigo-500',
    ];
    $bgColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-200 p-6']) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>

            @if($trend && $trendValue)
                <div class="mt-2 flex items-center text-sm">
                    @if($trend === 'up')
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-600 font-medium">{{ $trendValue }}</span>
                    @else
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-600 font-medium">{{ $trendValue }}</span>
                    @endif
                    <span class="text-gray-500 ml-1">vs mes anterior</span>
                </div>
            @endif
        </div>

        @if($icon)
            <div class="flex-shrink-0">
                <div class="{{ $bgColor }} rounded-lg p-3">
                    {!! $icon !!}
                </div>
            </div>
        @endif
    </div>
</div>
