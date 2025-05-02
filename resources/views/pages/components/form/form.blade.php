@extends('layouts.main')

@section('title', 'Components - Form')
@section('breadcrumb')
    @php
        $items = [
            ["label" => "Components"],
            ["label" => "Form"],
        ]
    @endphp
    <x-breadcrumb :items="$items"/>
@endsection

@section('page-title', 'Form')
@section('content')

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Form
                    </div>
                </div>
                <div class="card-body">

                    <x-form id="myForm" method="POST" action="{{ route('components.form.form.post') }}">
                        <div class="row">
                            <div class="col-6">
                                <x-field id="form_name:name" label="Name" required>
                                    <x-input id="form_name" placeholder="Enter Name" />
                                </x-field>

                                <x-field id="form_birthdate:birthdate" label="Birthdate" required>
                                    <x-date-picker id="form_birthdate" />
                                </x-field>

                                <x-field id="form_gender:gender" label="Gender" required>
                                    <x-select id="form_gender" :options="\App\Models\Gender::toSelect()" />
                                </x-field>

                                <x-checkbox id="active" label="Active" />
                            </div>

                            <div class="col-6">
                                <x-field id="form_email:email" label="Email" required>
                                    <x-input type="email" id="form_email" placeholder="Enter Email" />
                                </x-field>

                                <x-field id="form_password:password" label="Password" required>
                                    <x-password id="form_password" />
                                </x-field>

                                <x-field id="form_religion:religion" label="Religion" required>
                                    <x-radio-group name="form_religion" :options="\App\Models\Religion::toRadio()" inline />
                                </x-field>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-2">
                            <div class="col d-flex justify-content-end">
                                <x-button id="btn_submit" color="primary" type="submit" class="me-1">Submit</x-button>
                                <x-button id="btn_load1" color="secondary" class="me-1">Load data (Set Manual)</x-button>
                                <x-button id="btn_load2" color="secondary" class="me-1">Load data (Form Load Method)</x-button>
                                <x-button id="btn_loading" color="info" class="me-1">Loading</x-button>
                                <x-button id="btn_reset" color="warning" class="me-1">Reset</x-button>
                                <x-button id="btn_enabled" color="success" class="me-1">Enabled</x-button>
                                <x-button id="btn_disabled" color="danger" class="me-1">Disabled</x-button>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/pages/components/form.js'])
@endpush