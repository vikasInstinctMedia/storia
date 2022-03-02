<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BranchDeliverablePincode extends Model
{
    protected $guarded = ['id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public static function states()
    {
        // return cache()->remember('states', 60 * 60, function() {
            return DB::table('branch_deliverable_pincodes')->select('state')->groupBy('state')->pluck('state');
        // });
    }

    public static function cities($state = null)
    {
            return DB::table('branch_deliverable_pincodes')
                    ->when($state, function ($query, $state) {
                                return $query->where('state', $state);
                    })->select('city')->groupBy('city')->pluck('city');

    }
}
