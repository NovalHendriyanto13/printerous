<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_ORGANIZATION; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

     public function account() {
          return $this->belongsTo('App\Models\Account');
     }
}