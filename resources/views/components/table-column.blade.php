@props([
    "data" => null,
    "lookup" => false,
    "orderable" => false,
    "searchable" => false,
    "autoincrement" => false,
    "select_all" => false,
    "edit" => false,
    "delete" => false,
    "view" => false,
])

<th {{ 
    $attributes->merge([
        "data" => isset($data) && !empty($data) ? $data : null,
        "orderable" => $orderable === true && $autoincrement === false && $select_all === false,
        "searchable" => $searchable === true && $autoincrement === false && $select_all === false,
        "autoincrement" => $autoincrement === true && $select_all === false,
        "select_all" => $autoincrement === false && $select_all === true,
        "view" => $view === true,
        "edit" => $edit === true,
        "delete" => $delete === true,
        "lookup" => $autoincrement === false && $select_all === false && ($view === false && $edit === false && $delete === false) && $lookup === true
    ])
    ->class([
        "orderable" => $orderable === true && $autoincrement === false && $select_all === false,
    ])
}} scope="col">
    @if ($autoincrement === false && $select_all === true)
        <input class="form-check-input check-all" type="checkbox">
    @elseif ($autoincrement === true && $select_all === false)
        #
    @endif
    
    {{ $slot }}
    @if ($autoincrement === false && $select_all === false && $orderable === true)
    <span class="sort-icon">
        <i class="ri-arrow-up-down-line sort-icon-hover"></i>
        <i class="ri-arrow-down-line sort-icon-desc"></i>
        <i class="ri-arrow-up-line sort-icon-asc"></i>
    </span>
    @endif
</th>