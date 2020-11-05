<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DbTrait {
	
	public function transactionBegin() {
		return DB::beginTransaction();
	}

	public function transactionCommit() {
		return DB::commit();
	}

	public function transactionRollback() {
		return DB::rollback();
	}

	public function table(String $table) {
		return DB::table($table);
		}
}