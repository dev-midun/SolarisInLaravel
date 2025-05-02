@props([
    'id' => null,
    'stages' => []
])

<div id="{{ $id }}" class="stage-container">
    <div class="stage-group">
        @php
            $dropdown = [];
        @endphp

        @foreach ($stages as $stage)
            @php
                $isArray = is_array($stage);
                $stageId = $isArray ? $stage['id'] : $stage->id;
                $stageName = $isArray ? $stage['name'] : $stage->name;
                $stageColor = $isArray ? $stage['color'] : $stage->color;
                $stageConfirm = $isArray ? (isset($stage['confirm']) ? ($stage['confirm'] ? "true" : "false") : "false") : ($stage->confirm ? "true" : "false");
                $stageConfirmMessage = $isArray ? $stage['confirmMessage'] ?? "" : $stage->confirmMessage;
                $stageMenu = $isArray ? $stage['menu'] ?? null : $stage->menu;
                
                if(isset($stageMenu)) {
                    if($isArray && !empty($stageMenu)) {
                        $dropdown[$stageId] = $stageMenu;
                    } else if(!$isArray && $stageMenu->count() > 0) {
                        $dropdown[$stageId] = $stageMenu->toArray();
                    }
                }
            @endphp

            @if (count($dropdown) > 0)
                <div 
                    class="stage-button stage-button-dropdown stage-color-{{ $stageColor ?? "primary" }}" 
                    data-id="{{ $stageId }}" 
                    data-confirm="{{ $stageConfirm }}">
                    <button class="btn" type="button">
                        <span class="d-flex justify-content-between">
                            <span class="stage-text ">{{ $stageName }}</span>
                            <span class="stage-text-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 16 16" fit="" preserveAspectRatio="xMidYMid meet" focusable="false">
                                    <g transform="translate(-1783.779 74.455)">
                                    <g>
                                        <g>
                                        <path d="M1787.779-67.455l4,4,4-4Z" fill="currentColor"></path>
                                        </g>
                                    </g>
                                    </g>
                                    <rect width="16" height="16" fill="none"></rect>
                                </svg>
                            </span>
                        </span>
                    </button>
            @else
                <div class="stage-button stage-color-{{ $stageColor }}" data-id="{{ $stageId }}" data-confirm="{{ $stageConfirm }}">
                    <button type="button" class="btn"><span class="stage-text">{{ $stageName }}</span></button>
            @endif

            </div>
        @endforeach
    </div>

    @foreach ($dropdown as $key => $item)
    <div class="dropdown-menu" data-id="{{ $key }}">
        @foreach ($item as $menu)
        <a class="dropdown-item" href="#" data-id="{{ $menu['id'] }}" data-color="{{ $menu['color'] }}">{{ $menu['name'] }}</a>
        @endforeach
    </div>
    @endforeach
</div>