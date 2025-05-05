<x-modal-form id="account-modal" title="Account">
    <x-form id="account-modal-form" model="account">

		<div class="row mb-4">
			<div class="d-flex justify-content-center">
				<x-profile-picture id="account-modal-profile_picture"/>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
                <x-field id="account-modal-name:name" label="Name" required>
                    <x-input 
						id="account-modal-name" 
						placeholder="Type the account name here..."/>
                </x-field>
			</div>
			<div class="col-lg-6">
                <x-field id="account-modal-type_id:type_id" label="Type" required>
                    <x-select 
						id="account-modal-type_id" lookup 
						placeholder="Choose the account type" 
						dropdown_parent="#account-modal"
						:options="\App\Models\AccountType::toSelect()"/>
                </x-field>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
                <x-field id="account-modal-primary_contact_id:primary_contact_id" label="Primary contact">
                    <x-select 
						id="account-modal-primary_contact_id" 
						lookup 
						source="Account"
						extend_columns="type_id,industry_id,primary_phone"
						placeholder="Search and select a primary contact" 
						dropdown_parent="#account-modal"/>
                </x-field>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
                <x-field id="account-modal-primary_phone:primary_phone" label="Primary phone" required>
                    <x-input id="account-modal-primary_phone" placeholder="Enter the primary phone number"/>
                </x-field>
			</div>
			<div class="col-lg-6">
                <x-field id="account-modal-email:email" label="Email" required>
                    <x-input id="account-modal-email" placeholder="Provide an email address"/>
                </x-field>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
                <x-field id="account-modal-industry_id:industry_id" label="Industry" required>
                    <x-select 
						id="account-modal-industry_id" lookup 
						placeholder="Choose industry or sector" 
						dropdown_parent="#account-modal"
						:options="\App\Models\Industry::toSelect()"/>
                </x-field>
			</div>
		</div>

		<div class="hstack gap-2 justify-content-center mt-4">
			<x-button id="account-modal-save" type="submit">Save</x-button>
			<x-button data-bs-dismiss="modal" color="light" aria-label="Close">Cancel</x-button>
		</div>

    </x-form>
</x-modal-form>