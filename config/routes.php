<?php
$base = [
	'group'=>Authentication\GroupController::class,
	'user'=>Authentication\UserController::class,
	'module'=>Authentication\ModuleController::class,
	'menu'=>Authentication\MenuController::class,
	'permission'=>Authentication\PermissionController::class,
	'organization'=>Masters\OrganizationController::class,
	'person'=>Masters\PersonController::class,
	'account'=>Masters\AccountController::class,
	'occupation'=>Masters\OccupationController::class,
	'gallery'=>Masters\GalleryController::class,
];

foreach($base as $prefix=>$c) {
	Route::prefix($prefix)->group(function() use ($prefix, $c) {
		Route::get('/',['as'=>$prefix.'.index','uses'=>$c.'@index']);
		Route::get('create',['as'=>$prefix.'.create','uses'=>$c.'@create']);
		Route::post('create',['as'=>$prefix.'.create','uses'=>$c.'@createAction']);
		Route::get('update/{id}',['as'=>$prefix.'.update','uses'=>$c.'@update']);
		Route::match(['post','put'],'update/{id}',['as'=>$prefix.'.update','uses'=>$c.'@updateAction']);
		Route::get('detail/{id}',['as'=>$prefix.'.detail','uses'=>$c.'@detail']);
	});
}

// other route

// module
Route::get('module/get-action/{name}', ['as'=>'module.getAction','uses'=>'Authentication\ModuleController@getAction']);
// gallery
Route::post('gallery/remove-file',['as'=>'gallery.remove','uses'=>'Masters\GalleryController@remove']);
// user
Route::get('user/get-name',['as'=>'user.get_name','uses'=>'Authentication\UserController@getName']);
// organization
Route::get('organization/assign/{id}',['as'=>'organization.assign','uses'=>'Masters\OrganizationController@assign']);