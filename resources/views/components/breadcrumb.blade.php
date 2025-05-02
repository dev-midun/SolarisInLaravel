@props([
    "variant" => "default", // default, style-1, style-2, style-3, style-4
    "items" => [] // [['label' => '', 'url' => '']]
])

@php
    $items = is_iterable($items) ? collect($items)->values() : collect();
    $lastIndex = $items->count() - 1;
@endphp

<nav aria-label="breadcrumb">
    <ol {{
        $attributes->class([
            "breadcrumb",
            "breadcrumb-example1" => strtolower($variant) == "style-1",
            "breadcrumb-style1" => strtolower($variant) == "style-2",
            "breadcrumb-style2" => strtolower($variant) == "style-3",
        ])
        ->merge([
            "style" => strtolower($variant) == "style-4" ? "--bs-breadcrumb-divider: '~';" : null
        ])
    }}>
        @foreach ($items as $index => $item)
            @php
                $label = is_array($item) ? $item['label'] ?? '' : $item->label ?? '';
                $url = is_array($item) ? $item['url'] ?? null : $item->url ?? null;
            @endphp

            @if ($index === $lastIndex)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $label }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $url ?? 'javascript:void(0);' }}">
                        {{ $label }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>