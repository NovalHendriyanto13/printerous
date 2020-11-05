<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_PERMISSION; 

    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    public function group() {
        return $this->belongsTo('App\Models\Group','group_id');
    }

    public function menu() {
        return $this->belongsTo('App\Models\Menu','menu_id');
    }
}