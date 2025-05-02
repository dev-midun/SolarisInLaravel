<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Attachment;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactRepository extends BaseRepository
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function findComplete($id)
    {
        return $this->model
            ->defaultSelect([
                'id',
                'name',
                'also_known_as',
                'npwp',
                'no_ktp',
                'degree',
                'primary_phone',
                'primary_mobile_phone',
                'email',
                'job_title',
                'recency_date',
                'frequency',
                'monetary',
                'birth_date',
                'lifetime_value',
                'completeness',
                'last_meeting_status',
                'notes',
                'account_id',
                'gender_id',
                'religion_id',
                'preferred_language_id',
                'segmentation_id',
                'estimated_income_id',
                'marital_status_id',
                'salutation_id',
                'customer_journey_id',
                'education_id',
                'frequency_type_id',
                'socioeconomic_status_id',
                'currency_id',
                'profile_picture_id',
                'created_by_id'
            ])
            ->with(['created_by' => fn($query) => $query->select('id', 'name')])
            ->where('id', $id)
            ->first();
    }

    public function delete($id): bool
    {
        $success = false;
        try {
            DB::beginTransaction();

            $record = $this->find($id);
            $profilePictureId = $record->profile_picture_id;

            // ContactPreviousCompany
            // RelatedContact
            // ContactHobby
            // ContactNoteworthyEvent
            // ContactChannelNotUse
            // ContactCommunication
            // ContactAddress

            Account::where('primary_contact_id', $id)->update(['primary_contact_id' => null]);
            
            $success = $record->delete();

            if(!is_null($profilePictureId)) {
                $attachmentRepo = new AttachmentRepository(new Attachment());
                $attachmentRepo->delete($profilePictureId);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $success;
    }
}