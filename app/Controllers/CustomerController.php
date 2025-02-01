<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class CustomerController extends BaseController
{

    public function __construct(){ 
        $this->session = \Config\Services::session();
    }

    public function dashboard(){
        $user_id = $this->session->get('user_id');
        $userModel = new UserModel();

        $user = $userModel->find($user_id);
        return view('customer/dashboard', ['last_login' => $user['last_login'],'user' => $user]);

    }
}