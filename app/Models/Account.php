<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_ACCOUNT; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = [];
    
    public function occupation() {
		  return $this->belongsTo('App\Models\Occupation');
	  }

}