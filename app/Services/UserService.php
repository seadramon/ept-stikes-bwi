<?php
namespace App\Services;

use App\Models\User;
use DB;

class UserService
{
	
	function getData($role)
	{
		$data = User::where('role', $role)->paginate(1);

		return $data;
	}

	function update($id, $params)
	{

	}

	function addNew($params)
	{
		try {
			DB::beginTransaction();

			$data = new User;
			$data->name = $params['name'];
			$data->email = $params['email'];

			$data->save();

			DB::commit();

			return $data;
		} catch(\Exception $e) {
			DB:rollback();
			Log::error('Error insert User: '. __METHOD__ . ' '. $e->getMessage());

			return null;
		}
	}
}