<?php
namespace App\Http\Controllers\Dashboard\Index;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class IndexController extends BaseController {
	public $_baseUrl = '/';
	public $_baseView = 'index';
	public $_title = 'Dashboard';
}