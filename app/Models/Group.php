<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_GROUP; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = [];
    
    public function menu() {
    	return $this->hasToMany('App\Models\Menu','permission','group_id','menu_id');
    }

    public function getTable() {
    	return $this->table;
    }
}