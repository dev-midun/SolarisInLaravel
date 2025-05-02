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

    {{-- input --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Input
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-input id="input1" class="mb-3" placeholder="Default input" />
                            <x-input id="input2" class="mb-3" size="sm" placeholder="Small size" />
                            <x-input id="input3" class="mb-3" size="lg" placeholder="Large size" />
                        </div>
                        <div class="col-6">
                            <x-input id="input4" class="mb-3" rounded placeholder="Rounded input" />
                            <x-input id="input5" class="mb-3" square placeholder="Square input" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-input id="input6" class="mb-3" value="This is value" />
                            <x-password id="password1" class="mb-3" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- textarea --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Textarea
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-textarea id="textarea1" class="mb-3" placeholder="Default input" />
                            <x-textarea id="textarea2" class="mb-3" size="sm" placeholder="Small size" />
                            <x-textarea id="textarea3" class="mb-3" size="lg" placeholder="Large size" />
                        </div>
                        <div class="col-6">
                            <x-textarea id="textarea4" class="mb-3" rounded placeholder="Rounded input" />
                            <x-textarea id="textarea5" class="mb-3" square placeholder="Square input" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-textarea id="textarea6" class="mb-3" value="This is value" />
                            <x-textarea id="textarea7" rows="5" class="mb-3" placeholder="Rows 5" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- select --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Select
                    </div>
                </div>
                <div class="card-body">

                    @php
                        $selectOptions_arr = [
                            ["text" => "One", "value" => "one"],
                            ["text" => "Two", "value" => "two"],
                            ["text" => "Three", "value" => "three"],
                        ];
                        $selectOptions_obj = [
                            (object)["text" => "One", "value" => "one"],
                            (object)["text" => "Two", "value" => "two"],
                            (object)["text" => "Three", "value" => "three"],
                        ];
                        $selectOptions_arr2 = [
                            ["text" => "One", "value" => "one"],
                            ["text" => "Two", "value" => "two", "selected" => true],
                            ["text" => "Three", "value" => "three"],
                        ];
                    @endphp

                    <div class="row">
                        <div class="col-6">
                            <x-select id="select1" class="mb-3" :options="$selectOptions_arr" />
                            <x-select id="select2" class="mb-3" :options="$selectOptions_arr2" />
                            <x-select id="select3" class="mb-3" :options="$selectOptions_obj" rounded />
                            <x-select id="select4" class="mb-3" :options="$selectOptions_obj" square />
                        </div>
                        <div class="col-6">
                            <x-select id="select5" class="mb-3" size="sm" :options="$selectOptions_arr" placeholder="I'm small" />
                            <x-select id="select6" class="mb-3" :options="$selectOptions_arr" placeholder="I'm default" />
                            <x-select id="select7" class="mb-3" size="lg" :options="$selectOptions_arr" placeholder="I'm large" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <x-select id="select_multiple1" class="mb-3" multiple :options="$selectOptions_arr" />
                        </div>
                        <div class="col-6">
                            <x-select id="select_multiple2" class="mb-3" multiple :options="$selectOptions_arr2" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <x-select id="lookup1" lookup placeholder="This is lookup" :options="$selectOptions_arr" />
                            </div>
                            <div class="mb-3">
                                <x-select id="lookup2" lookup multiple placeholder="This is multiple lookup" :options="$selectOptions_arr" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-select id="lookup3" lookup lazy placeholder="Lazy lookup" :options="$selectOptions_arr" />
                            </div>
                            <div class="mb-3">
                                <x-select id="lookup4" lookup multiple lazy placeholder="Lazy multiple lookup" :options="$selectOptions_arr" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- lookup --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Lookup (Combobox)
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <x-select id="lookup1" lookup placeholder="This is lookup" :options="$selectOptions_arr" />
                            </div>
                            <div class="mb-3">
                                <x-select id="lookup2" lookup multiple placeholder="This is multiple lookup" :options="$selectOptions_arr" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-select id="lookup3" lookup lazy placeholder="Lazy lookup" :options="$selectOptions_arr" />
                            </div>
                            <div class="mb-3">
                                <x-select id="lookup4" lookup multiple lazy placeholder="Lazy multiple lookup" :options="$selectOptions_arr" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- date picker --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Date picker
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-date-picker id="date_picker1" placeholder="Date picker" class="mb-3" />
                            <x-date-picker id="datetime_picker1" mode="datetime" placeholder="Date & time picker" class="mb-3" />
                        </div>
                        <div class="col-6">
                            <x-date-picker id="date_picker2" placeholder="Date picker" class="mb-3" value="2000-02-19" />
                            <x-date-picker id="datetime_picker2" mode="datetime" placeholder="Date & time picker" class="mb-3" value="2025-04-14 12:18" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-date-picker id="time_picker1" mode="time" placeholder="Time picker" class="mb-3" />
                        </div>
                        <div class="col-6">
                            <x-date-picker id="time_picker2" mode="time" placeholder="Time picker" class="mb-3" value="18:00" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-date-picker id="date_range_picker1" range placeholder="Date range picker" class="mb-3" />
                        </div>
                        <div class="col-6">
                            <x-date-picker id="date_range_picker2" mode="datetime" range placeholder="Date & Time range picker" class="mb-3" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- checkbox --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Checkbox
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-checkbox id="checkbox1" label="I'm ugly" wrap:class="mb-3" />
                            <x-checkbox id="checkbox2" label="I'm handsome" wrap:class="mb-3" checked />
                            <x-checkbox id="checkbox3" label="I'm square" wrap:class="mb-3" square />
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-checkbox id="checkbox4" label="You ugly" checked inline />
                                <x-checkbox id="checkbox5" label="You handsome" inline />
                            </div>
                            <div class="mb-3">
                                <x-checkbox id="checkbox6" label="I'm default" inline />
                                <x-checkbox id="checkbox7" label="I'm medium" size="md" inline />
                                <x-checkbox id="checkbox8" label="I'm large" size="lg" inline />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <x-checkbox id="checkbox9" color="primary" label="I'm primary" checked inline />
                                <x-checkbox id="checkbox10" color="secondary" label="I'm secondary" checked inline />
                                <x-checkbox id="checkbox11" color="info" label="I'm info" checked inline />
                                <x-checkbox id="checkbox12" color="success" label="I'm success" checked inline />
                                <x-checkbox id="checkbox13" color="danger" label="I'm danger" checked inline />
                                <x-checkbox id="checkbox14" color="warning" label="I'm warning" checked inline />
                                <x-checkbox id="checkbox15" color="dark" label="I'm dark" checked inline />
                                <x-checkbox id="checkbox16" color="light" label="I'm lighy" checked inline />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-checkbox id="checkbox17" variant="outline" color="primary" label="I'm primary" checked inline />
                                <x-checkbox id="checkbox18" variant="outline" color="secondary" label="I'm secondary" checked inline />
                                <x-checkbox id="checkbox19" variant="outline" color="info" label="I'm info" checked inline />
                                <x-checkbox id="checkbox20" variant="outline" color="success" label="I'm success" checked inline />
                                <x-checkbox id="checkbox21" variant="outline" color="danger" label="I'm danger" checked inline />
                                <x-checkbox id="checkbox22" variant="outline" color="warning" label="I'm warning" checked inline />
                                <x-checkbox id="checkbox23" variant="outline" color="dark" label="I'm dark" checked inline />
                                <x-checkbox id="checkbox24" variant="outline" color="light" label="I'm lighy" checked inline />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-checkbox id="checkbox25" switch label="I'm ugly" inline wrap:class="mb-3" />
                            <x-checkbox id="checkbox26" switch label="I'm handsome" inline wrap:class="mb-3" checked />
                            <x-checkbox id="checkbox27" switch label="I'm square" inline wrap:class="mb-3" square />
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-checkbox id="checkbox28" color="primary" label="I'm primary" switch checked inline />
                                <x-checkbox id="checkbox29" color="secondary" label="I'm secondary" switch checked inline />
                                <x-checkbox id="checkbox30" color="info" label="I'm info" switch checked inline />
                                <x-checkbox id="checkbox31" color="success" label="I'm success" switch checked inline />
                                <x-checkbox id="checkbox32" color="danger" label="I'm danger" switch checked inline />
                                <x-checkbox id="checkbox33" color="warning" label="I'm warning" switch checked inline />
                                <x-checkbox id="checkbox34" color="dark" label="I'm dark" switch checked inline />
                                <x-checkbox id="checkbox35" color="light" label="I'm lighy" switch checked inline />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- checkbox group --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Checkbox Group
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @php
                                $religionArr = [
                                    ["label" => "Islam", "id" => "islam"],
                                    ["label" => "Kristen", "id" => "kristen"],
                                    ["label" => "Budha", "id" => "budha"],
                                    ["label" => "Hindu", "id" => "hindu"]
                                ];
                                $beautyObj = [
                                    (object)["label" => "Beauty", "id" => "beuaty"],
                                    (object)["label" => "Angle", "id" => "angle"]
                                ]
                            @endphp
                            <x-checkbox-group name="checkbox_group_array" :options="$religionArr" wrap:class="mb-3" />
                            <x-checkbox-group name="checkbox_group_object" :options="$beautyObj" wrap:class="mb-3" />
                            <x-checkbox-group 
                                name="checkbox_group_inline" 
                                wrap:class="mb-3"
                                :options="[
                                    ['label' => 'I handsome', 'id' => 'handsome_', 'checked' => true], 
                                    ['label' => 'You ugly', 'id' => 'ugly_']
                                ]" 
                                inline />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- radio --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Radio
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-radio id="radio1" label="I'm ugly" wrap:class="mb-3" />
                            <x-radio id="radio2" label="I'm handsome" wrap:class="mb-3" checked />
                            <x-radio id="radio3" label="I'm square" wrap:class="mb-3" square />
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-radio id="radio4" label="You ugly" checked inline />
                                <x-radio id="radio5" label="You handsome" inline />
                            </div>
                            <div class="mb-3">
                                <x-radio id="radio6" label="I'm default" inline />
                                <x-radio id="radio7" label="I'm medium" size="md" inline />
                                <x-radio id="radio8" label="I'm large" size="lg" inline />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <x-radio id="radio9" color="primary" label="I'm primary" checked inline />
                                <x-radio id="radio10" color="secondary" label="I'm secondary" checked inline />
                                <x-radio id="radio11" color="info" label="I'm info" checked inline />
                                <x-radio id="radio12" color="success" label="I'm success" checked inline />
                                <x-radio id="radio13" color="danger" label="I'm danger" checked inline />
                                <x-radio id="radio14" color="warning" label="I'm warning" checked inline />
                                <x-radio id="radio15" color="dark" label="I'm dark" checked inline />
                                <x-radio id="radio16" color="light" label="I'm lighy" checked inline />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-radio id="radio17" variant="outline" color="primary" label="I'm primary" checked inline />
                                <x-radio id="radio18" variant="outline" color="secondary" label="I'm secondary" checked inline />
                                <x-radio id="radio19" variant="outline" color="info" label="I'm info" checked inline />
                                <x-radio id="radio20" variant="outline" color="success" label="I'm success" checked inline />
                                <x-radio id="radio21" variant="outline" color="danger" label="I'm danger" checked inline />
                                <x-radio id="radio22" variant="outline" color="warning" label="I'm warning" checked inline />
                                <x-radio id="radio23" variant="outline" color="dark" label="I'm dark" checked inline />
                                <x-radio id="radio24" variant="outline" color="light" label="I'm lighy" checked inline />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- radio group --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Radio Group
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @php
                                $genderArr = [
                                    ["label" => "Male", "id" => "male_arr"],
                                    ["label" => "Female", "id" => "female_arr"]
                                ];
                                $handsomeObj = [
                                    (object)["label" => "Handsome", "id" => "handsome_obj"],
                                    (object)["label" => "Ugly", "id" => "ugly_obj"]
                                ]
                            @endphp
                            <x-radio-group name="radio_group_array" :options="$genderArr" wrap:class="mb-3" />
                            <x-radio-group name="radio_group_object" :options="$handsomeObj" wrap:class="mb-3" />
                            <x-radio-group 
                                name="radio_group_inline" 
                                wrap:class="mb-3"
                                :options="[
                                    ['label' => 'I handsome', 'id' => 'handsome', 'checked' => true], 
                                    ['label' => 'You ugly', 'id' => 'ugly']
                                ]" 
                                inline />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- input field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Input field
                    </div>
                </div>
                <div class="card-body">
                    {{-- input field --}}
                    <div class="row">
                        {{-- input field: vertical --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="input_field1" label="Default input">
                                <x-input id="input_field1" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="input_field2" label="Required input" required>
                                <x-input id="input_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="input_field3" label="Valid input" valid message="This input is valid">
                                <x-input id="input_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="input_field4" label="Error input" error message="This input is error">
                                <x-input id="input_field4" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="input_field5" label="Default value">
                                <x-input id="input_field5" value="This is default value" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="input_field6" label="Disabled" disabled>
                                <x-input id="input_field6" />
                            </x-field>
                        </div>

                        {{-- input field: horizontal --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="input_field7" label="Default input" horizontal>
                                <x-input id="input_field7" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="input_field8" label="Required input" required horizontal>
                                <x-input id="input_field8" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="input_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-input id="input_field9" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="input_field10" label="Error input" error message="This input is error" horizontal>
                                <x-input id="input_field10" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="input_field11" label="Default value" horizontal>
                                <x-input id="input_field11" value="This is default value" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="input_field12" label="Disabled" disabled horizontal>
                                <x-input id="input_field12" />
                            </x-field>
                        </div>

                    </div>

                    <h6 class="card-title fw-medium mt-3">Field with custom class/attribute</h6>
                    <hr>

                    {{-- input field with custom class/attribute --}}
                    <div class="row">
                        <div class="col-6">
                            <x-field id="input_field13" label="Label with custom class" label:class="text-danger">
                                <x-input id="input_field13" placeholder="input class='w-50'"/>
                            </x-field>

                            <x-field id="input_field14" label="Field with custom class" field:class="px-3">
                                <x-input id="input_field14" placeholder="field class='px-3'"/>
                            </x-field>
                        </div>
                        <div class="col-6">
                            <x-field id="input_field15" label="Label with custom class" label:class="text-danger" horizontal>
                                <x-input id="input_field15" placeholder="input class='w-50'"/>
                            </x-field>

                            <x-field id="input_field16" label="Field with custom class" field:class="px-3" horizontal>
                                <x-input id="input_field16" placeholder="field class='px-3'"/>
                            </x-field>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- textarea field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Textarea Field
                    </div>
                </div>
                <div class="card-body">
                    {{-- textarea field --}}
                    <div class="row">
                        {{-- input field: vertical --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="textarea_field1" label="Default input">
                                <x-textarea id="textarea_field1" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="textarea_field2" label="Required input" required>
                                <x-textarea id="textarea_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="textarea_field3" label="Valid input" valid message="This input is valid">
                                <x-textarea id="textarea_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="textarea_field4" label="Error input" error message="This input is error">
                                <x-textarea id="textarea_field4" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="textarea_field5" label="Default value">
                                <x-textarea id="textarea_field5" value="This is default value" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="textarea_field6" label="Disabled" disabled>
                                <x-textarea id="textarea_field6" />
                            </x-field>
                        </div>

                        {{-- input field: horizontal --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="textarea_field7" label="Default input" horizontal>
                                <x-textarea id="textarea_field7" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="textarea_field8" label="Required input" required horizontal>
                                <x-textarea id="textarea_field8" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="textarea_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-textarea id="textarea_field9" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="textarea_field10" label="Error input" error message="This input is error" horizontal>
                                <x-textarea id="textarea_field10" placeholder="John Doe"/>
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="textarea_field11" label="Default value" horizontal>
                                <x-textarea id="textarea_field11" value="This is default value" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="textarea_field12" label="Disabled" disabled horizontal>
                                <x-textarea id="textarea_field12" />
                            </x-field>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- password field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Password Field
                    </div>
                </div>
                <div class="card-body">
                    {{-- password field --}}
                    <div class="row">

                        {{-- input field: vertical --}}
                        <div class="col-6">
                            {{-- default password --}}
                            <x-field id="password_field1" label="Password">
                                <x-password id="password_field1" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="password_field2" label="Required password" required>
                                <x-password id="password_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="password_field3" label="Valid password" valid message="This input is valid">
                                <x-password id="password_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="password_field4" label="Error password" error message="This input is error">
                                <x-password id="password_field4" />
                            </x-field>
                            
                            {{-- disabled --}}
                            <x-field id="password_field5" label="Disabled" disabled>
                                <x-password id="password_field5" />
                            </x-field>
                        </div>
                        
                        {{-- input field: horizontal --}}
                        <div class="col-6">
                            {{-- default password --}}
                            <x-field id="password_field6" label="Password" horizontal>
                                <x-password id="password_field6" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="password_field7" label="Required password" required horizontal>
                                <x-password id="password_field7" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="password_field8" label="Valid password" valid message="This input is valid" horizontal>
                                <x-password id="password_field8" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="password_field9" label="Error password" error message="This input is error" horizontal>
                                <x-password id="password_field9" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="password_field10" label="Disabled" disabled horizontal>
                                <x-password id="password_field10" />
                            </x-field>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- date field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Date Field
                    </div>
                </div>
                <div class="card-body">
                    {{-- date field --}}
                    <div class="row">

                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="date_field1" label="Date">
                                <x-date-picker id="date_field1" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="date_field2" label="Required input" required>
                                <x-date-picker id="date_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="date_field3" label="Valid input" valid message="This input is valid">
                                <x-date-picker id="date_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="date_field4" label="Error input" error message="This input is error">
                                <x-date-picker id="date_field4" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="date_field5" label="Default value">
                                <x-date-picker id="date_field5" value="1995-02-27" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="date_field6" label="Disabled" disabled>
                                <x-date-picker id="date_field6" />
                            </x-field>
                        </div>

                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="date_field7" label="Date" horizontal>
                                <x-date-picker id="date_field7" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="date_field8" label="Required input" required horizontal>
                                <x-date-picker id="date_field8" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="date_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-date-picker id="date_field9" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="date_field10" label="Error input" error message="This input is error" horizontal>
                                <x-date-picker id="date_field10" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="date_field11" label="Default value" horizontal>
                                <x-date-picker id="date_field11" value="1995-02-27" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="date_field12" label="Disabled" disabled horizontal>
                                <x-date-picker id="date_field12" />
                            </x-field>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Datetime field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Date & Time Field
                    </div>
                </div>
                <div class="card-body">
                    {{-- date field --}}
                    <div class="row">

                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="datetime_field1" label="Date">
                                <x-date-picker mode="datetime" id="datetime_field1" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="datetime_field2" label="Required input" required>
                                <x-date-picker mode="datetime" id="datetime_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="datetime_field3" label="Valid input" valid message="This input is valid">
                                <x-date-picker mode="datetime" id="datetime_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="datetime_field4" label="Error input" error message="This input is error">
                                <x-date-picker mode="datetime" id="datetime_field4" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="datetime_field5" label="Default value">
                                <x-date-picker mode="datetime" id="datetime_field5" value="1995-02-27" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="datetime_field6" label="Disabled" disabled>
                                <x-date-picker mode="datetime" id="datetime_field6" />
                            </x-field>
                        </div>

                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="datetime_field7" label="Date" horizontal>
                                <x-date-picker mode="datetime" id="datetime_field7" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="datetime_field8" label="Required input" required horizontal>
                                <x-date-picker mode="datetime" id="datetime_field8" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="datetime_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-date-picker mode="datetime" id="datetime_field9" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="datetime_field10" label="Error input" error message="This input is error" horizontal>
                                <x-date-picker mode="datetime" id="datetime_field10" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="datetime_field11" label="Default value" horizontal>
                                <x-date-picker mode="datetime" id="datetime_field11" value="1995-02-27" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="datetime_field12" label="Disabled" disabled horizontal>
                                <x-date-picker mode="datetime" id="datetime_field12" />
                            </x-field>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- time field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Date & Time Field
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="time_field1" label="Date">
                                <x-date-picker mode="time" id="time_field1" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="time_field2" label="Required input" required>
                                <x-date-picker mode="time" id="time_field2" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="time_field3" label="Valid input" valid message="This input is valid">
                                <x-date-picker mode="time" id="time_field3" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="time_field4" label="Error input" error message="This input is error">
                                <x-date-picker mode="time" id="time_field4" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="time_field5" label="Default value">
                                <x-date-picker mode="time" id="time_field5" value="09:45" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="time_field6" label="Disabled" disabled>
                                <x-date-picker mode="time" id="time_field6" />
                            </x-field>
                        </div>

                        {{-- date picker --}}
                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="time_field7" label="Date" horizontal>
                                <x-date-picker mode="time" id="time_field7" placeholder="Date picker" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="time_field8" label="Required input" required horizontal>
                                <x-date-picker mode="time" id="time_field8" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="time_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-date-picker mode="time" id="time_field9" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="time_field10" label="Error input" error message="This input is error" horizontal>
                                <x-date-picker mode="time" id="time_field10" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="time_field11" label="Default value" horizontal>
                                <x-date-picker mode="time" id="time_field11" value="23:00" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="time_field12" label="Disabled" disabled horizontal>
                                <x-date-picker mode="time" id="time_field12" />
                            </x-field>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- select field --}}
    <div class="row">
        <div class="col">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Select Field
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="select_field1" label="Select">
                                <x-select id="select_field1" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="select_field2" label="Required input" required>
                                <x-select id="select_field2" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="select_field3" label="Valid input" valid message="This input is valid">
                                <x-select id="select_field3" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="select_field4" label="Error input" error message="This input is error">
                                <x-select id="select_field4" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="select_field5" label="Default value">
                                <x-select id="select_field5" value="one" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="select_field6" label="Disabled" disabled>
                                <x-select id="select_field6" />
                            </x-field>
                        </div>

                        <div class="col-6">
                            {{-- default field --}}
                            <x-field id="select_field7" label="Select" horizontal>
                                <x-select id="select_field7" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with required --}}
                            <x-field id="select_field8" label="Required input" required horizontal>
                                <x-select id="select_field8" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with valid state --}}
                            <x-field id="select_field9" label="Valid input" valid message="This input is valid" horizontal>
                                <x-select id="select_field9" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with error state --}}
                            <x-field id="select_field10" label="Error input" error message="This input is error" horizontal>
                                <x-select id="select_field10" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- field with value --}}
                            <x-field id="select_field11" label="Default value" horizontal>
                                <x-select id="select_field11" value="one" :options="$selectOptions_arr" />
                            </x-field>

                            {{-- disabled --}}
                            <x-field id="select_field12" label="Disabled" disabled horizontal>
                                <x-select id="select_field12" />
                            </x-field>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <x-field id="lookup_field1" label="Select">
                                <x-select id="lookup_field1" lookup placeholder="This is lookup" :options="$selectOptions_arr" />
                            </x-field>
                            <x-field id="lookup_field2" label="Select">
                                <x-select id="lookup_field2" lookup multiple placeholder="This is multiple lookup" :options="$selectOptions_arr" />
                            </x-field>
                        </div>
                        <div class="col-6">
                            <x-field id="lookup_field3" label="Select" horizontal lazy>
                                <x-select id="lookup_field3" lookup placeholder="Lazy lookup" :options="$selectOptions_arr" />
                            </x-field>
                            <x-field id="lookup_field4" label="Select" horizontal lazy>
                                <x-select id="lookup_field4" lookup multiple placeholder="Lazy multiple lookup" :options="$selectOptions_arr" />
                            </x-field>
                        </div>
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
                        Option Field
                    </div>
                </div>
                <div class="card-body">

                    {{-- checkbox --}}
                    <div class="row">
                        <div class="col-6">

                        </div>

                        <div class="col-6">

                        </div>
                    </div>

                    {{-- radio --}}
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/pages/components/form.js'])
@endpush