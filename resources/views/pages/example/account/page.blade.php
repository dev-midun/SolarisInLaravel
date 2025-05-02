@extends('layouts.main')

@section('top-buttons')
    <x-button>Save</x-button>
    <x-button color="secondary" variant="outline">Cancel</x-button>
@endsection
@section('content')

@php
    $accountStatus = [
        [
            'id' => 1,
            'name' => 'Personal Information',
            'color' => 'primary',
            'confirm' => true
        ],
        [
            'id' => 2,
            'name' => 'Draft',
            'color' => 'secondary',
            'confirm' => true
        ],
        [
            'id' => 3,
            'name' => 'Verification',
            'color' => 'info',
            'confirm' => true
        ],
        [
            'id' => 4,
            'name' => 'Approve',
            'color' => 'success',
            'confirm' => true
        ]
    ];
@endphp

<div class="row mb-3">
    <div class="col">
        <x-stage-buttons 
            id="accounts-status"
            :stages="$accountStatus" 
            />
    </div>
</div>


{{-- 

<x-tab>
    <x-slot:nav>
        <x-tab-nav/>
        <x-tab-nav/>
        <x-tab-nav/>
        <x-tab-nav/>
        <x-tab-nav/>
    </x-slot:nav>
    <x-slot:content>
        <x-tab-content>
        <x-tab-content>
        <x-tab-content>
        <x-tab-content>
        <x-tab-content>
    </x-slot:content>
</x-tab>

--}}

<div class="row">
    <div class="col-9">
        <div class="card custom-card">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3 tab-style-6" id="myTab3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="products-tab" data-bs-toggle="tab"
                            data-bs-target="#products-tab-pane" type="button" role="tab"
                            aria-controls="products-tab-pane" aria-selected="true"><i
                                class="ri-gift-line me-1 align-middle d-inline-block"></i>General Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sales-tab" data-bs-toggle="tab"
                            data-bs-target="#sales-tab-pane" type="button" role="tab"
                            aria-controls="sales-tab-pane" aria-selected="false"><i
                                class="ri-bill-line me-1 align-middle d-inline-block"></i>CRM Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profit-tab" data-bs-toggle="tab"
                            data-bs-target="#profit-tab-pane" type="button" role="tab"
                            aria-controls="profit-tab-pane" aria-selected="false"><i
                                class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Contacts</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="expenses-tab" data-bs-toggle="tab"
                            data-bs-target="#expenses-tab-pane" type="button" role="tab"
                            aria-controls="expenses-tab-pane" aria-selected="false"><i
                                class="ri-exchange-box-line me-1 align-middle d-inline-block"></i>Timeline</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="expenses-tab" data-bs-toggle="tab"
                            data-bs-target="#expenses-tab-pane" type="button" role="tab"
                            aria-controls="expenses-tab-pane" aria-selected="false"><i
                                class="ri-exchange-box-line me-1 align-middle d-inline-block"></i>History</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active p-0 border-0 overflow-hidden" id="products-tab-pane" role="tabpanel" aria-labelledby="products-tab" tabindex="0">
                        <div class="row">
                            <div class="col-6">
                                <x-field label="Name" id="accounts-page-name:name" required>
                                    <x-input id="accounts-page-name" placeholder="Type the account name here..."/>
                                </x-field>

                                <x-field label="Email address" id="accounts-page-email:email" required>
                                    <x-input id="accounts-page-email" placeholder="Provide an email address"/>
                                </x-field>

                                <x-field label="Owner" id="accounts-page-created_by_id:created_by_id" required>
                                    <x-select id="accounts-page-created_by_id" lookup/>
                                </x-field>

                                <x-field label="Category" id="accounts-page-category:category" required>
                                    <x-input id="accounts-page-category" placeholder="Type the category here"/>
                                </x-field>

                                <x-field label="Also known as" id="accounts-page-also_known_as:also_known_as">
                                    <x-input id="accounts-page-also_known_as" placeholder="Enter any alternate names"/>
                                </x-field>

                                <x-field label="Annual revenue" id="accounts-page-annual_revenue_id:annual_revenue_id">
                                    <x-select id="annual_revenue_id" lookup placeholder="Choose annual revenue"/>
                                </x-field>
                            </div>
                            <div class="col-6">
                                <x-field label="Primary contact" id="accounts-page-primary_contact_id:primary_contact_id">
                                    <x-select id="accounts-page-primary_contact_id" lookup placeholder="Choose the primary contact"/>
                                </x-field>

                                <x-field label="Primary phone" id="accounts-page-primary_phone:primary_phone" required>
                                    <x-input id="accounts-page-primary_phone" placeholder="Enter the primary phone number"/>
                                </x-field>

                                <x-field label="Type" id="accounts-page-type_id:type_id" required>
                                    <x-select id="accounts-page-type_id" lookup placeholder="Type the category here" :options="\App\Models\AccountType::toSelect()"/>
                                </x-field>

                                <x-field label="Industry" id="accounts-page-industry_id:industry_id" required>
                                    <x-select id="accounts-page-industry_id" lookup placeholder="Choose industry or sector"/>
                                </x-field>

                                <x-field label="Business entity" id="accounts-page-business_entity_id:business_entity_id">
                                    <x-select id="accounts-page-business_entity_id" lookup placeholder="Choose business entity"/>
                                </x-field>

                                <x-field label="No. of employees" id="accounts-page-number_of_employee_id:number_of_employee_id">
                                    <x-select id="accounts-page-number_of_employee_id" lookup placeholder="Choose total number of employees"/>
                                </x-field>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade overflow-hidden border-0" id="sales-tab-pane" role="tabpanel"
                        aria-labelledby="sales-tab" tabindex="0">
                        <div class="row">
                            <div class="col-6">
                                <x-field label="Customer journey" id="accounts-page-customer_journey_id:customer_journey_id">
                                    <x-select id="accounts-page-customer_journey_id" lookup placeholder="Choose customer journey"/>
                                </x-field>

                                <x-field label="Recency" id="accounts-page-recency_date:recency_date">
                                    <x-date-picker id="accounts-page-recency_date" placeholder="Pick the most recent activity date"/>
                                </x-field>

                                <x-field label="Monetary" id="accounts-page-monetary:monetary">
                                    <x-input id="accounts-page-monetary" placeholder="Enter the monetary value"/>
                                </x-field>
                            </div>
                            <div class="col-6">
                                <x-field label="Segmentation" id="accounts-page-segmentation_id:segmentation_id">
                                    <x-select id="accounts-page-segmentation_id" lookup placeholder="Specify the market segment"/>
                                </x-field>

                                <x-field label="Frequency" id="accounts-page-frequency_type_id:frequency_type_id">
                                    <x-select id="accounts-page-frequency_type_id" lookup placeholder="Enter how often this occurs" />
                                </x-field>

                                <x-field label="Business size" id="accounts-page-business_size_id:business_size_id">
                                    <x-select id="accounts-page-business_size_id" lookup placeholder="Specify the size of your business"/>
                                </x-field>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade overflow-hidden border-0" id="profit-tab-pane" role="tabpanel"
                        aria-labelledby="profit-tab" tabindex="0">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Clothing
                                    </div>
                                    <div class="fs-14 fw-medium text-success"><i
                                            class="ri-arrow-up-s-fill me-1 align-middle"></i>22.75%
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        electronics
                                    </div>
                                    <div class="fs-14 fw-medium text-success"><i
                                            class="ri-arrow-up-s-fill me-1 align-middle"></i>42.24%
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Furniture
                                    </div>
                                    <div class="fs-14 fw-medium text-success"><i
                                            class="ri-arrow-up-s-fill me-1 align-middle"></i>15.23%
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Home Appliances
                                    </div>
                                    <div class="fs-14 fw-medium text-success"><i
                                            class="ri-arrow-up-s-fill me-1 align-middle"></i>15.14%
                                    </div>
                                </div>
                            </li>
                            <li class="mb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        food Products
                                    </div>
                                    <div class="fs-14 fw-medium text-success"><i
                                            class="ri-arrow-up-s-fill me-1 align-middle"></i>31.64%
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade overflow-hidden border-0" id="expenses-tab-pane" role="tabpanel"
                        aria-labelledby="expenses-tab" tabindex="0">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Clothing
                                    </div>
                                    <div class="fs-14 fw-medium text-danger">-$31,134</div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        electronics
                                    </div>
                                    <div class="fs-14 fw-medium text-danger">-$15,256</div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Furniture
                                    </div>
                                    <div class="fs-14 fw-medium text-danger">-$24,156</div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Home Appliances
                                    </div>
                                    <div class="fs-14 fw-medium text-danger">-$18,245</div>
                                </div>
                            </li>
                            <li class="mb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        food Products
                                    </div>
                                    <div class="fs-14 fw-medium text-danger">-$18,478</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">

    </div>
</div>

@endsection

@push('scripts')
    {{-- @vite(['resources/js/pages/accounts/page.js']) --}}
@endpush