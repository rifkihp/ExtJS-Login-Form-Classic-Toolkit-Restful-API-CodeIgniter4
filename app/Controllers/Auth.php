<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\User;
use App\Controllers\BaseController;

class Auth extends BaseController
{
	use ResponseTrait;

	public function index()
	{
		//
	}

	public function prosesLogin() {

		$validation = \Config\Services::validation();

		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$params = [
			'username' => $username,
			'password' => $password
		];


		if($validation->run($params, 'auth') == FALSE) {
			$response = [
				'status' => 500,
				'error'  => true,
				'data'   => $validation->getErrors()
			];

			return $this->respond($response, 500);
		}


		$password_sha1 = sha1($password);

		$model = new User();
		$user = $model->getUserLogin($username, $password_sha1);
		
		if($user) {
			$response = [
				'status' => 200,
				'error'  => false,
				'user'   => $user,
				'success' => true 
			];

			return $this->respond($response, 200);
		} else {

			$response = [
				'status' => 401,
				'error'  => true,
				'data'   =>[
					'message' => 'Username dan Password Tidak Sesuai.'
				]
			];

			return $this->respond($response, 401);
		}
	}
}
