<?php

namespace App\Controllers;

use App\Models\DonationModel;

class Home extends BaseController
{
    public function index(): string
    {
        helper('form');
        return view('landing_page');
    }

    public function donate()
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[120]',
            'phone' => 'required|regex_match[/^\d{3}-\d{3,4}\s?\d{4}$/]',
            'email' => 'required|valid_email|max_length[255]',
            'food_type' => 'required|max_length[150]',
            'estimated_quantity' => 'required|max_length[120]',
            'preferred_date' => 'required|valid_date[Y-m-d]',
            'preferred_time' => 'required|regex_match[/^\d{2}:\d{2}$/]',
            'pickup_address' => 'required|max_length[255]',
            'notes' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/')->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new DonationModel();
        $model->insert([
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'food_type' => $this->request->getPost('food_type'),
            'estimated_quantity' => $this->request->getPost('estimated_quantity'),
            'preferred_datetime' => $this->request->getPost('preferred_date') . ' ' . $this->request->getPost('preferred_time'),
            'pickup_address' => $this->request->getPost('pickup_address'),
            'notes' => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/')->with('success', 'Thanks for your donation!');
    }
}
