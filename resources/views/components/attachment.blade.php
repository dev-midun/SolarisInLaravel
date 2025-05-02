@props([
    "id",
    "chunk_size" => 2000000,
    "upload_message" => "Drop files here or click to upload.",
    "relation" => null
])

@php
    $filter = [];
    if(!empty($relation) && str_contains($relation, ":")) {
        $splitRelation = explode(":", $relation);
        $tableName = $splitRelation[0];
        $recordId = $splitRelation[1];
        $filter = [
            "table_name:{$tableName}",
            "record_id:{$recordId}"
        ];
    }
@endphp

<div id="{{ $id }}" solar-ui="attachment" chunk-size="{{ $chunk_size }}">
    <div id="{{ $id }}_upload" class="dropzone mb-3">
        <div class="fallback">
            <input name="file" type="file" multiple="multiple">
        </div>
        <div class="dz-message needsclick">
            <h6>{{ $upload_message }}</h6>
        </div>
    </div>
    
    <x-table 
        id="{{ $id }}_table" 
        class="table-hover" 
        model="Attachment" 
        search refresh info pagination lazy
        :filter="$filter" 
        :page="10">
        <x-slot:column>
            <x-table-column select_all/>
            <x-table-column autoincrement/>
            <x-table-column data="file_name" searchable orderable>Name</x-table-column>
            <x-table-column data="created_at" orderable>Upload at</x-table-column>
            <x-table-column delete />
        </x-slot>
    </x-table>
</div>