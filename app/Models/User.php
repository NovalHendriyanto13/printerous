<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_USER; 

    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'password' => false,
        // 'created_by' => Auth::user()->id
    ];

    public function group() {
        return $this->hasOne('App\Models\Group','id','group_id');
    }
}