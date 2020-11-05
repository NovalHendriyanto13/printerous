<?php
namespace Lib;

use Illuminate\Http\Request;
use Image;

class Upload {
	
	protected $request;
	protected $file;

	private $_imagePath;
	private $_h;
	private $_w;

	public function __construct(Request $request = null) {
		$this->request = $request;
		$this->_imagePath = public_path(config('app.image_path.original'));
		list($this->_w, $this->_h) = config('app.image_size.thumbnail');
		
	}
	public function setParam(String $param) {
		$this->file = $this->request->file($param);
	}
	public function process($path, $filename) {
		$newPath = [
			'original'=>config('app.image_path.original').$path.'/',
			'thumbnail'=>config('app.image_path.original').$path.'/thumbnail/',
		];
		
		if (!is_dir($this->_imagePath.$path) || !is_dir($this->_imagePath.$path.'/thumbnail/')) {
			$newPath = $this->createDir($path);
		}
		
		if ($this->file) {
			if ($this->file->move($newPath['original'], $filename)) {
				
				$thumb = Image::make($newPath['original'].$filename);
				$thumb->resize($this->_w, $this->_h, function ($constraint) {
					$constraint->aspectRatio();
				})->save($newPath['thumbnail'].$filename);

				return [
					'status'=>true,
					'message'=>'Upload image is success',
					'image'=> $path.'/'.$filename,
					'thumb'=> $path.'/thumbnail/'.$filename,
					'path'=>$path,
					'thumb_path'=>$path.'/thumbnail',
				];
			}

			return [
				'status'=>true,
				'message'=>'Upload image is failed',
				'image'=>'',
				'thumb'=>'',
				'path'=>'',
				'thumb_path'=>'',
			];
		}
		return [
			'status'=>false,
			'message'=>'No Parameter Found',
			'image_path'=>'',
			'thumb'=>'',
			'path'=>'',
			'thumb_path'=>'',
		];
	}
	public function createDir(String $path) {
		$explodePath = explode('/', $path);

		$folderPath = '';
		for($i=0; $i < count($explodePath); $i++) {
			$folder = $explodePath[$i];
			// check if folder exists
			$folderPath .= $folder;
			if(!is_dir($this->_imagePath.$folderPath)) {
				mkdir($this->_imagePath.$folderPath, 0777);
			}
			$folderPath .= '/';
		}
		//thumbnail path
		$thumbPath = $folderPath.'thumbnail/';
		if (!is_dir($this->_imagePath.$folderPath.'thumbnail'))
			mkdir($this->_imagePath.$folderPath.'thumbnail',0777);
		
		return [
			'original'=>config('app.image_path.original').$folderPath,
			'thumbnail'=>config('app.image_path.original').$thumbPath,
		];
	}

	public function removeFile(String $path=null) {
		if(is_file($this->_imagePath.$path))
			unlink($this->_imagePath.$path);
		
		return true;
	}
}