<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]'
        ];

        $response = [
            'status' =>  200,
            'message' => 'user alredy register',
        ];


        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

     
 

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ];

        $this->model->save($data);

        $response = [
            'status' =>  200,
            'message' => 'User registered successfully',
        ];

        // Kembalikan respons dengan status code 201
        return $this->respondCreated($response);    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $user = $this->model->where('username', $this->request->getVar('username'))->first();



        $response = [
            'status' =>  401,
            'message' => 'Invalid login credentials',
        ];

        if (!$user || !password_verify($this->request->getVar('password'), $user['password'])) {
            return $this->respond($response);
        }

        $response = [
            'status' =>  200,
            'message' => 'Login successful',
        ];

        return $this->respond($response);
    }
}