<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_PERSON; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
     protected $guarded = [];
     
     public function organization() {
		return $this->hasOne('App\Models\Organization','id','organization_id');
	}

}