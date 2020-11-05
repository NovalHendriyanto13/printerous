<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_MODULE; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function menu() {
		return $this->belongsTo('App\Models\User');
	}
}