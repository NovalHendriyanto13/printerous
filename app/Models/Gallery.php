<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_GALLERY; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

}