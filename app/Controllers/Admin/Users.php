<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Users',
            'pageTitle' => 'User Management',
            'users' => $users,
        ];

        return view('admin/users/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|max_length[255]|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'role' => 'required|in_list[super_admin,admin,driver,viewer]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password_hash' => $this->request->getPost('password'),
                'role' => $this->request->getPost('role'),
                'status' => 'active',
            ];

            $this->userModel->insert($data);

            return redirect()->to('/admin/users')->with('success', 'User created successfully.');
        }

        $data = [
            'title' => 'Add User',
            'pageTitle' => 'Add User',
        ];

        return view('admin/users/add', $data);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|max_length[255]|is_unique[users.email,id,{$id}]",
                'role' => 'required|in_list[super_admin,admin,driver,viewer]',
                'status' => 'required|in_list[active,inactive]',
            ];

            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[6]';
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
                'status' => $this->request->getPost('status'),
            ];

            if ($this->request->getPost('password')) {
                $data['password_hash'] = $this->request->getPost('password');
            }

            $this->userModel->update($id, $data);

            return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
        }

        $data = [
            'title' => 'Edit User',
            'pageTitle' => 'Edit User',
            'user' => $user,
        ];

        return view('admin/users/edit', $data);
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        // Prevent deleting yourself
        if ($id == session()->get('admin_user_id')) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }
}
