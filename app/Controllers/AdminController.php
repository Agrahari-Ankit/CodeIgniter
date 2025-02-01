<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\EducationModel;
use App\Models\EmploymentModel;
use Intervention\Image\ImageManagerStatic as Image;


class AdminController extends BaseController
{
    public function __construct(){ 
        $this->session = \Config\Services::session();
    }

    public function dashboard(){
        $userModel = new UserModel();
        $user_id = $this->session->get('user_id');
        $user = $userModel->find($user_id);
        
        $totalUsers = $userModel->countAll();
        $recentUsers = $userModel->where('role', 'customer')->orderBy('id', 'DESC')->limit(5)->find(); 

        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'totalUsers' => $totalUsers,
            'recentUsers' => $recentUsers,
            'last_login' => $user['last_login']
        ]);
    }

    public function getUsers(){
        $userModel = new UserModel();
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5; 

        $users = $userModel->where('role', 'customer')->paginate($perPage);
        $pager = $userModel->pager;

        return $this->response->setStatusCode(200)->setJSON([
            'users' => $users,
            'pagination' => [
                'currentPage' => $pager->getCurrentPage(),
                'perPage' => $perPage,
                'totalPages' => $pager->getPageCount(),
                'totalUsers' => $pager->getTotal(),
            ]
        ]);
    }


    public function getUser($id) {
        $model = new UserModel(); 
        $user = $model->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'User not found']);
        }
 
        return view('admin/edit-profile', ['user' => $user]);
    }

    public function updateUser($id) { 
        $model = new UserModel();
        $data = $this->request->getJSON();  
    
        if (empty($data->first_name) || empty($data->last_name) || empty($data->email)) {
            return $this->response->setStatusCode(401)->setJSON(['message' =>'First name, last name, and email are required']);
        }
    
        $updateData = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'role' => 'customer'
        ];
     
        if (!empty($data->password) && $data->password === $data->confirm_password) {
            $updateData['password'] = password_hash($data->password, PASSWORD_DEFAULT);
        } elseif (!empty($data->password) || !empty($data->confirm_password)) {
            return $this->response->setStatusCode(401)->setJSON(['message' =>'Passwords do not match']);
        }
     
        if ($model->update($id, $updateData)) {
            return $this->response->setStatusCode(200)->setJSON(['message' => 'User updated successfully']);
        } else {
            return $this->response->setStatusCode(401)->setJSON(['message' =>'Failed to update user']);
        }
    }

    public function deleteUser($id){ 
        $this->userModel = new UserModel(); 
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON(['message' => 'User not found.'], 404);
        }

        if ($this->userModel->delete($id)) {
            return $this->response->setJSON(['message' => 'User deleted successfully!']);
        } else {
            return $this->response->setJSON(['message' => 'Failed to delete the user.'], 500);
        }
    }


    public function getEducation($userId){
        $educationModel = new EducationModel();
        $education = $educationModel->where('user_id', $userId)->first();

        return $this->response->setJSON($education);
    }

    public function saveEducation(){
        $educationModel = new EducationModel();
        $data = [
            'user_id'     => $this->request->getPost('user_id'),
            'highest_education'      => $this->request->getPost('highest_education'),
            'university' => $this->request->getPost('university'),
            'college'        => $this->request->getPost('college'),
            'percentage'        => $this->request->getPost('percentage'),
            'year_of_passing'        => $this->request->getPost('year_of_passing'),
        ];

        $existing = $educationModel->where('user_id', $data['user_id'])->first();

        if ($existing) {
            $educationModel->update($existing['id'], $data);
            return $this->response->setJSON(['message' => 'Education updated successfully']);
        } else {
            $educationModel->insert($data);
            return $this->response->setJSON(['message' => 'Education added successfully']);
        }
    }


    public function getEmployment($user_id) {
        $model = new EmploymentModel();
        $employment = $model->where('user_id', $user_id)->first();

        return $this->response->setJSON($employment);
    }

    public function saveEmployment() {
        $model = new EmploymentModel();
        $data = $this->request->getPost();

        $existing = $model->where('user_id', $data['user_id'])->first();

        if ($existing) {
            $model->update($existing['id'], $data);
            return $this->response->setJSON(['message' => 'Employment details updated!']);
        } else {
            $model->insert($data);
            return $this->response->setJSON(['message' => 'Employment details added!']);
        }
    }


    public function view($userId){
        $userModel = new UserModel();
        $educationModel = new EducationModel();
        $employmentModel = new EmploymentModel();

        // Fetch user details
        $user = $userModel->find($userId);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        $education = $educationModel->where('user_id', $userId)->first();
        $employment = $employmentModel->where('user_id', $userId)->first();

        // Pass the data to the view
        return view('admin/view-profile', [
            'user'       => $user,
            'education'  => $education,
            'employment' => $employment,
        ]);
    }


    public function uploadImage($userId){
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $path = FCPATH . 'uploads/' . $newName;  
            if (!is_dir(FCPATH . 'uploads')) {
                mkdir(FCPATH . 'uploads', 0777, true);  
            }
            $img = \Config\Services::image()
                        ->withFile($image->getTempName())
                        ->resize(500, 500, true)  
                        ->save($path, 75);  
            $userModel = new \App\Models\UserModel();
            $userModel->update($userId, ['profile_image' => '/uploads/' . $newName]);
     
            return $this->response->setJSON([
                'message' => 'Image uploaded successfully',
                'imageUrl' => '/uploads/' . $newName
            ]);
        } else {
            log_message('error', 'Failed to upload image: ' . $image->getErrorString());
            return $this->response->setJSON(['message' => 'Failed to upload image']);
        }
    }

}
