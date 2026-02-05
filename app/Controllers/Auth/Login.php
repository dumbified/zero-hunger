<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->has('admin_logged_in') && session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        helper('form');
        return view('auth/login');
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByUsername($username);
        
        if (!$user || !$this->userModel->verifyPassword($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        // Set session data
        $sessionData = [
            'admin_logged_in' => true,
            'admin_user_id' => $user['id'],
            'admin_username' => $user['username'],
            'admin_email' => $user['email'],
            'admin_role' => $user['role'],
        ];

        session()->set($sessionData);

        // Update last login
        $this->userModel->updateLastLogin($user['id']);

        return redirect()->to('/admin/dashboard')->with('success', 'Welcome back, ' . $user['username'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'You have been logged out successfully.');
    }
}
