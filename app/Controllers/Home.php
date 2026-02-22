<?php

namespace App\Controllers;

use App\Models\DonationModel;
use App\Models\RecipientModel;

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

    public function requestHelp()
    {
        $rules = [
            'type' => 'required|in_list[individual,organization]',
            'name' => 'required|min_length[2]|max_length[255]',
            'phone' => 'required|regex_match[/^\d{3}-\d{3,4}\s?\d{4}$/]',
            'email' => 'required|valid_email|max_length[255]',
            'address' => 'required|max_length[255]',
            'service_area' => 'required|max_length[100]',
            'notes' => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/')->withInput()->with('errors', $this->validator->getErrors());
        }

        $phone = (string) $this->request->getPost('phone');
        $email = (string) $this->request->getPost('email');
        $notes = trim((string) $this->request->getPost('notes'));

        $model = new RecipientModel();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'phone' => $phone,
            'email' => $email,
            'address' => $this->request->getPost('address'),
            'service_area' => $this->request->getPost('service_area'),
            'notes' => $notes !== '' ? $notes : null,
            // New requests should be reviewed/approved by admin first
            'status' => 'inactive',
        ]);

        return redirect()->to('/')->with('success', 'Request submitted! We will contact you soon.');
    }
}
