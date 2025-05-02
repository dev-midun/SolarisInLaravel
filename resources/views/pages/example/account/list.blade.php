@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col">
            <x-table id="account_table" class="table-hover" model="Account" all_feature :page="10" lazy>
                <x-slot:column>
                    <x-table-column select_all/>
                    <x-table-column autoincrement/>
                    <x-table-column data="name" searchable orderable>Name</x-table-column>
                    <x-table-column name="type_id" data="type.name" searchable orderable>Type</x-table-column>
                    <x-table-column data="primary_phone" searchable orderable>Phone number</x-table-column>
                    <x-table-column data="email" searchable orderable>Email</x-table-column>
                    <x-table-column data="industry.name" lookup searchable orderable>Industry</x-table-column>
                    <x-table-column edit delete />
                </x-slot>
            </x-table>
        </div>
    </div>

@endsection

@push('modal-content')
    @include("pages.example.account.modal")
@endpush

@push('scripts')
    @vite(['resources/js/pages/example/account/list.js'])
@endpush