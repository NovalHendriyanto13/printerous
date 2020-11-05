<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = BaseTable::TBL_MENU; 
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function parent() {
		return $this->belongsTo('App\Models\Menu','parent_id');
	}

	public function module() {
		return $this->hasOne('App\Models\Module','id','module_id');
	}

	public function setMenu(Int $groupId = 0) {

		if(is_root()) {
			$menus = $this->select([
				$this->table.'.name', 
				$this->table.'.action' ,
				$this->table.'.status' ,
				$this->table.'.icon' , 
				$this->table.'.menu_group' , 
				$this->table.'.sort_number' ,
				'b.name as parent', 
				'c.name as module', 
				'c.initial'
			])
				->leftJoin(BaseTable::TBL_MENU.' AS b',$this->table.'.parent_id','=','b.id')
				->leftJoin(BaseTable::TBL_MODULE.' AS c', $this->table.'.module_id','=','c.id')
				->whereNotNull($this->table.'.parent_id')
				->where($this->table.'.status',1)
				->get();

			return $menus;
		}

		$menus = $this->select([
			$this->table.'.name', 
			$this->table.'.action' ,
			$this->table.'.status' ,
			$this->table.'.icon' , 
			$this->table.'.menu_group' , 
			$this->table.'.sort_number' ,
			'b.name as parent', 
			'c.name as module', 
			'c.initial'
		])
			->leftJoin(BaseTable::TBL_MENU.' AS b',$this->table.'.parent_id','=','b.id')
			->leftJoin(BaseTable::TBL_MODULE.' AS c', $this->table.'.module_id','=','c.id')
			->leftJoin(BaseTable::TBL_PERMISSION.' AS d', 'c.id','=','d.module_id')
			->whereNotNull($this->table.'.parent_id')
			->where($this->table.'.status',1)
			->orderBy($this->table.'.sort_number');

		if ($groupId > 0)
			$menus = $menus->where('d.group_id', $groupId);

		return $menus->get();

	}
}