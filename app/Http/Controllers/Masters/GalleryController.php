<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\BaseController;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lib\Upload;

class GalleryController extends BaseController {
	protected $_baseUrl = 'gallery';
	protected $_title = 'Gallery';
	protected $_model = Gallery::class;

	public function createAction(Request $request) {
		$data = $request->all();
		
		// validation
		$validate = Validator::make($data, $this->validation());
		if ($validate->fails()) {
			return response()->json([
				'status'=>false,
				'data'=>[],
				'errors'=>[
					'messages'=>$validate->messages()->getMessages(),
				],
				'redirect'=>false,
			]);
		}

		$upload = new Upload($request);
		$filename = '';
		if($request->hasFile('image')) {
			$file = $data['image'];
			$rand = rand(1, 1000);
			$filename = $data['tablename'].'_'.$data['table_id'].'_'.$rand.'.'.$file->getClientOriginalExtension();
			
			$upload->setParam('image');
			$uploadFile = $upload->process('gallery/'.$data['tablename'].'/'.$data['name'], $filename);
			$data['original_path'] = $uploadFile['path'];
			$data['thumb_path'] = $uploadFile['thumb_path'];
		}
		$model = $this->_model::where([
			'name'=>$data['name'],
			'tablename'=>$data['tablename'],
			'table_id'=>$data['table_id']
		])->first();

		unset($data['image']);
		if ($model) {
			$action = $this->_model::where('id', $model->id)->update($data);
		}
		else {
			$action = $this->_model::create($data);
		}

		if($action) {
			$request->session()->flash('status', 'Upload Image was successful!');
			$data['filename'] = $filename;
			return response()->json([
				'status'=>true,
				'data'=>$data,
				'errors'=>[],
				'redirect'=>false,
			]);
		}

		return response()->json([
			'status'=>false,
			'data'=>[],
			'errors'=>[
				'messages'=>'Invalid Input',
			],
			'redirect'=>false,
		]);
	}

	public function remove(Request $request) {
		$data = $request->all();
		$filePath = $this->getBasePath($data['file']);
		$thumbPath = $this->getThumbPath($data['file']);
		
		$response = [];
		if (is_file($filePath)) {
			if(!unlink($filePath))
				$response[] = false;
		}
		
		if (is_file($thumbPath)){
			if(!unlink($thumbPath))
				$response[] = false;
		}
		
		if (in_array(false, $response)) {
			return response()->json(['status'=>false]);
		}
		return response()->json(['status'=>true]);
	}
	protected function validation() {
		return [
			'image'=>'image|mimes:jpeg,png,jpg',
			'name'=>'required',
		];
	}
	private function getBasePath($fileUrl) {
		$assetUrl = config('app.url');
		$baseFile = str_replace('thumbnail/','',substr($fileUrl, strlen($assetUrl)));

		return public_path($baseFile);
	}
	private function getThumbPath($fileUrl) {
		$assetUrl = config('app.url');
		$baseFile = substr($fileUrl, strlen($assetUrl));

		return public_path($baseFile);
	}
 
}