<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index(){
        return view('login');
    }


    public function login(){
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password'); 
        $user = $userModel->where('email', $email)->first(); 
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Invalid email or password.',
            ]);
        }
 
        $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]); 
        session()->set('role', $user['role']);  
        session()->set('user_id', $user['id']);  
 
        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'role' => $user['role']
            ]
        ]);
    }

    



    public function registerIndex(){
        return view('register');
    }


    public function register() {
    $userModel = new UserModel();

    $rules = [
        'first_name' => 'required|min_length[2]',
        'last_name' => 'required|min_length[2]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'matches[password]',
    ];

    // Validate the incoming request data
    if (!$this->validate($rules)) {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $this->validator->getErrors()
        ]);
    }

    $data = [
        'first_name' => $this->request->getPost('first_name'),
        'last_name' => $this->request->getPost('last_name'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => 'customer',
        'last_login' => null,
    ];

    try {
        // Attempt to insert the user data
        $userModel->insert($data);

        // Return a successful response
        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        // Catch any errors during user registration
        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'error',
            'message' => 'Error while registering user: ' . $e->getMessage()
        ]);
    }
}

    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
