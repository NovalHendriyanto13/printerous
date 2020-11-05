<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Gallery as galleryModel;

class Gallery extends Component
{
    /**
     * Attributes 
     *
     * @var Gallery
     */
    public $_items;
    /**
     * Attributes 
     *
     * @var String
     */
    public $_tablename;
    /**
     * Attributes 
     *
     * @var String
     */
    public $_tableId;
    /**
     * Attributes 
     *
     * @var String
     */
    public $_allowDuplicate;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tablename, $tableId, $allowDuplicate=false)
    {
        $this->_items = $this->loadGallery($tablename, $tableId);
        $this->_tablename = $tablename;
        $this->_tableId = $tableId;
        $this->_allowDuplicate = $allowDuplicate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.gallery',[
            'items'=>$this->_items,
            'tablename'=>$this->_tablename,
            'table_id'=>$this->_tableId,
            'allow_duplicate'=>$this->_allowDuplicate,
        ]);
    }

    private function loadGallery($tableName, $id) {
		$model = galleryModel::where([
			'tablename'=>$tableName,
			'table_id'=>$id
		])->first();
        
        $basePath = public_path(config('app.image_path.original'));
		$images = [];
		if ($model) {
            // $path = $basePath.$model->original_path;
            $path = $basePath.$model->thumb_path;
			if (is_dir($path)) {
				foreach (scandir($path) as $value) {
					if (!in_array($value, ['.','..'])) {
						$images[] = $model->thumb_path.'/'.$value;
					}
				}
			}
		}

		return $images;
	}
}
