<?php

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityRepository extends BaseRepository
{
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }

    public function findComplete($id)
    {
        return $this->model
            ->defaultSelect([
                'id',
                'subject',
                'start_date',
                'end_date',
                'category_id',
                'priority_id',
                'status_id',
                'result_id',
                'account_id',
                'contact_id',
                'lead_id',
                'opportunity_id',
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

            // ContactPreviousCompany
            // RelatedContact
            // ContactHobby
            // ContactNoteworthyEvent
            // ContactChannelNotUse
            // ContactCommunication
            // ContactAddress
            
            $success = parent::delete($id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $success;
    }
}