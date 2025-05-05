@props([
    "id",
    "model" => null,
    "new" => false,
    "search" => false,
    "refresh" => false,
    "import" => false,
    "export" => false,
    "sort" => [], // ['name', 'title', 'active', 'direction'],
    "pagination" => false,
    "info" => false,
    "page" => 5,
    "all_feature" => false,
    // filter by string => column_name:column_value --> ex: account_id:01967a55-a247-7084-b0c0-29c85c2663fc
    // filter group by array string => ["column_name:column_value", "column_name:column_value"] --> ex: ["account_id:01967a55-a247-7084-b0c0-29c85c2663fc", "account_id:01967a55-a247-7084-b0c0-29c85c2663fc"]
    "filter" => null,
    "horizontal" => false,
    "extend_columns" => null
])

<div class="card custom-card" id="{{ $id }}_wrapper">
    <div class="card-header align-items-center">

        @if (isset($header))
        {{ $header }}
        @else

        <div class="d-flex justify-content-between flex-fill">

            <div class="d-flex align-items-center flex-wrap gap-2">
                @if ($new === true || $all_feature === true)
                <x-button id="{{ $id }}_new" size="sm"><span class="ri-add-fill me-1"></span>New</x-button>
                @endif

                @if (!empty($sort) && is_array($sort))
                <div class="dropdown" id="{{ $id }}_sort">
                    <x-button icon variant="outline" color="light" size="sm" id="{{ $id }}_sort_button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-filter-3-fill"></i>
                    </x-button>
                    <ul class="dropdown-menu">
                        @foreach ($sort as $item)
                            <li><a 
                                class="dropdown-item fs-12 {{ isset($item["active"]) ? 'active' : '' }}" 
                                href="javascript:void(0);" 
                                order-by="{{ $item['name'] }}"
                                direction="{{ $item['direction'] ?? 'ASC' }}">
                                {{ $item['title'] }}
                            </a></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (($import === true || $export === true) || $all_feature === true)
                <div class="dropdown" id="{{ $id }}_action">
                    <x-button icon variant="outline" color="light" size="sm" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-fill"></i>
                    </x-button>
                    <ul class="dropdown-menu">
                        @if ($export || $all_feature === true)
                        <li><a class="dropdown-item fs-12 export-action" href="javascript:void(0);"><i class="ri-download-line me-1"></i>Download</a></li>
                        @endif
        
                        @if ($import || $all_feature === true)
                        <li><a class="dropdown-item fs-12 import-action" href="javascript:void(0);"><i class="ri-upload-line me-1"></i>Upload</a></li>
                        @endif
                    </ul>
                </div>
                @endif

                @if (isset($button))
                {{ $button }}
                @endif

                <span id="{{ $id }}_selected_info"></span>
                <x-button id="{{ $id }}_selected_delete" size="sm" variant="outline" color="light" hidden><span class="ri-delete-bin-7-line me-1"></span>Delete All</x-button>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if ($search === true || $all_feature === true)
                <x-search-input id="{{ $id }}_search" size="sm" placeholder="Search" />
                @endif

                @if ($refresh === true || $all_feature === true)
                <x-button id="{{ $id }}_refresh" size="sm" icon variant="outline" color="light"><i class="ri-refresh-line"></i></x-button>
                @endif
            </div>

        </div>

        @endif
    </div>
    <div class="card-body p-0">
        @if ($horizontal === false)
        <div class="table-responsive">
        @endif
            <table {{ 
                $attributes->class(["table", "solar-table"])
                    ->merge([
                        "id" => $id, 
                        "model" => $model, 
                        "page" => $page,
                        "solar-ui" => "table",
                        "horizontal" => $horizontal === true,
                        "extend-columns" => !empty($extend_columns) ? $extend_columns : null, 
                        "filter" => !empty($filter) && !is_array($filter) ? json_encode([$filter]) : (!empty($filter) ? json_encode($filter) : null)
                    ]) 
            }}>
                @if (isset($column))
                    <thead>
                        <tr>
                            {{ $column }}
                        </tr>
                    </thead>
                @endif
                
                <tbody>
                    @if (isset($body))
                        {{ $body }}
                    @endif
                </tbody>
            </table>
        @if ($horizontal === false)
        </div>
        @endif
    </div>
    <div class="card-footer border-top-0">
        <div class="d-flex align-items-center">
            @if ($info === true || $all_feature === true)
            <div id="{{ $id }}_info">
                No entries available 😔
            </div>
            @endif

            @if ($pagination === true || $all_feature === true)
            <div id="{{ $id }}_pagination" class="ms-auto">
                <nav aria-label="Page navigation" class="pagination-style-4">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link prev-paginate" href="javascript:void(0);">
                                Prev
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link current-paginate" href="javascript:void(0);">1</a></li>
                        <li class="page-item disabled">
                            <a class="page-link next-paginate" href="javascript:void(0);">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>