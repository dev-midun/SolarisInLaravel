@extends('layouts.main')

@section('title', 'Components - Button')
@section('breadcrumb')
    @php
        $items = [
            ["label" => "Components"],
            ["label" => "Button"],
        ]
    @endphp
    <x-breadcrumb :items="$items"/>
@endsection

@section('page-title', 'Button')
@section('content')

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Default Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button id="button1">Primary</x-button>
                        <x-button id="button2" color="secondary">Secondary</x-button>
                        <x-button id="button3" color="info">Info</x-button>
                        <x-button id="button4" color="success">Success</x-button>
                        <x-button id="button5" color="danger">Danger</x-button>
                        <x-button id="button6" color="warning">Warning</x-button>
                        <x-button id="button7" color="light">Light</x-button>
                        <x-button id="button8" color="dark">Dark</x-button>
                        <x-button id="button9" color="primary">Loading</x-button>
                        <x-button id="button10" color="primary">Disabled</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Outline Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button id="button11" variant="outline" color="primary">Primary</x-button>
                        <x-button id="button12" variant="outline" color="secondary">Secondary</x-button>
                        <x-button id="button13" variant="outline" color="info">Info</x-button>
                        <x-button id="button14" variant="outline" color="success">Success</x-button>
                        <x-button id="button15" variant="outline" color="danger">Danger</x-button>
                        <x-button id="button16" variant="outline" color="warning">Warning</x-button>
                        <x-button id="button17" variant="outline" color="light">Light</x-button>
                        <x-button id="button18" variant="outline" color="dark">Dark</x-button>
                        <x-button id="button19" variant="outline" color="primary">Loading</x-button>
                        <x-button id="button20" variant="outline" color="primary">Disabled</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Light Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button id="button21" variant="light" color="primary">Primary</x-button>
                        <x-button id="button22" variant="light" color="secondary">Secondary</x-button>
                        <x-button id="button23" variant="light" color="info">Info</x-button>
                        <x-button id="button24" variant="light" color="success">Success</x-button>
                        <x-button id="button25" variant="light" color="danger">Danger</x-button>
                        <x-button id="button26" variant="light" color="warning">Warning</x-button>
                        <x-button id="button27" variant="light" color="primary">Loading</x-button>
                        <x-button id="button28" variant="light" color="primary">Disabled</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Ghost Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button id="button29" variant="ghost" color="primary">Primary</x-button>
                        <x-button id="button30" variant="ghost" color="secondary">Secondary</x-button>
                        <x-button id="button31" variant="ghost" color="info">Info</x-button>
                        <x-button id="button32" variant="ghost" color="success">Success</x-button>
                        <x-button id="button33" variant="ghost" color="danger">Danger</x-button>
                        <x-button id="button34" variant="ghost" color="warning">Warning</x-button>
                        <x-button id="button35" variant="ghost" color="primary">Loading</x-button>
                        <x-button id="button36" variant="ghost" color="primary">Disabled</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Gradient Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button id="button37" variant="gradient" color="primary">Primary</x-button>
                        <x-button id="button38" variant="gradient" color="secondary">Secondary</x-button>
                        <x-button id="button39" variant="gradient" color="info">Info</x-button>
                        <x-button id="button40" variant="gradient" color="success">Success</x-button>
                        <x-button id="button41" variant="gradient" color="danger">Danger</x-button>
                        <x-button id="button42" variant="gradient" color="warning">Warning</x-button>
                        <x-button id="button43" variant="gradient" color="primary">Loading</x-button>
                        <x-button id="button44" variant="gradient" color="primary">Disabled</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Size Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button size="sm">Small</x-button>
                        <x-button>Default</x-button>
                        <x-button size="lg">Large</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Custom Button
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-list">
                        <x-button rounded>Rounded</x-button>
                        <x-button square>Square</x-button>
                        <x-button variant="link">Link</x-button>
                        <x-button icon><i class="bx bx-home"></i></x-button>
                        <x-button><i class="bx bx-home"></i>Label & Icon</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/pages/components/button.js'])
@endpush