<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountAddress;
use App\Models\AccountBank;
use App\Models\AccountCommunication;
use App\Models\AccountNoteworthyEvent;
use App\Models\AccountRelatedCompany;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AccountRepository extends BaseRepository
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    public function findComplete($id)
    {
        return $this->model
            ->defaultSelect([
                'id', 
                'name',
                'website',
                'email',
                'primary_phone',
                'email',
                'npwp',
                'also_known_as',
                'group_company',
                'recency_date',
                'frequency',
                'monetary',
                'notes',
                'type_id',
                'customer_journey_id',
                'segmentation_id',
                'frequency_type_id',
                'business_size_id',
                'ownership_type_id',
                'number_of_employee_id',
                'annual_revenue_id',
                'business_entity_id',
                'industry_id',
                'currency_id',
                'profile_picture_id',
                'created_by_id',
                // 'primary_contact_id'
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

            // AccountAddress::where('account_id', $id)->delete();
            // AccountCommunication::where('account_id', $id)->delete();
            // AccountBank::where('account_id', $id)->delete();
            // AccountNoteworthyEvent::where('account_id', $id)->delete();
            // AccountRelatedCompany::where('account_id', $id)->delete();
            
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