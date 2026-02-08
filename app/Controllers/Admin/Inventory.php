<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\DonationModel;

class Inventory extends BaseController
{
    protected $inventoryModel;
    protected $donationModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
        $this->donationModel = new DonationModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $expiring = $this->request->getGet('expiring');
        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;

        $builder = $this->inventoryModel->builder();

        // Include donor information (from donations table) for each inventory item
        // Use LEFT JOIN so items without donation_id still show
        $builder->select('inventory.*, donations.full_name AS donor_name')
                ->join('donations', 'donations.id = inventory.donation_id', 'left');

        // Apply filters
        if ($status && $status !== 'all') {
            $builder->where('status', $status);
        }

        if ($expiring) {
            $today = date('Y-m-d');
            $futureDate = date('Y-m-d', strtotime("+{$expiring} days"));
            $builder->where('expiration_date >=', $today)
                ->where('expiration_date <=', $futureDate)
                ->where('status', 'available');
        }

        if ($search) {
            $builder->groupStart()
                ->like('food_type', $search)
                ->orLike('storage_location', $search)
                ->orLike('donations.full_name', $search)
                ->groupEnd();
        }

        // Get total count for pagination
        $total = $builder->countAllResults(false);

        // Apply pagination
        $inventory = $builder->orderBy('expiration_date', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        $pager = \Config\Services::pager();
        $pager->store('inventory', $page, $perPage, $total);

        // Get expiring items count
        $expiringSoon = $this->inventoryModel->getExpiringItems(7);
        $expired = $this->inventoryModel->getExpiredItems();

        $data = [
            'title' => 'Inventory',
            'pageTitle' => 'Inventory Management',
            'inventory' => $inventory,
            'pager' => $pager,
            'currentStatus' => $status ?? 'all',
            'expiring' => $expiring,
            'search' => $search,
            'expiringSoon' => $expiringSoon,
            'expired' => $expired,
            'statuses' => ['all', 'available', 'reserved', 'distributed', 'expired'],
        ];

        return view('admin/inventory/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'food_type' => 'required|max_length[150]',
                'quantity' => 'required|decimal',
                'unit' => 'permit_empty|max_length[50]',
                'expiration_date' => 'permit_empty|valid_date',
                'storage_location' => 'permit_empty|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'food_type' => $this->request->getPost('food_type'),
                'quantity' => $this->request->getPost('quantity'),
                'unit' => $this->request->getPost('unit') ?? 'kg',
                'expiration_date' => $this->request->getPost('expiration_date') ?: null,
                'storage_location' => $this->request->getPost('storage_location'),
                'status' => 'available',
            ];

            if ($this->request->getPost('donation_id')) {
                $data['donation_id'] = $this->request->getPost('donation_id');
            }

            $this->inventoryModel->insert($data);

            return redirect()->to('/admin/inventory')->with('success', 'Inventory item added successfully.');
        }

        // Get pending donations for dropdown
        $donations = $this->donationModel->where('status', 'pending')
            ->orWhere('status', 'confirmed')
            ->findAll();

        $data = [
            'title' => 'Add Inventory',
            'pageTitle' => 'Add Inventory Item',
            'donations' => $donations,
        ];

        return view('admin/inventory/add', $data);
    }

    public function edit($id)
    {
        $item = $this->inventoryModel->find($id);

        if (!$item) {
            return redirect()->to('/admin/inventory')->with('error', 'Inventory item not found.');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'food_type' => 'required|max_length[150]',
                'quantity' => 'required|decimal',
                'unit' => 'permit_empty|max_length[50]',
                'expiration_date' => 'permit_empty|valid_date',
                'storage_location' => 'permit_empty|max_length[100]',
                'status' => 'required|in_list[available,reserved,distributed,expired]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'food_type' => $this->request->getPost('food_type'),
                'quantity' => $this->request->getPost('quantity'),
                'unit' => $this->request->getPost('unit') ?? 'kg',
                'expiration_date' => $this->request->getPost('expiration_date') ?: null,
                'storage_location' => $this->request->getPost('storage_location'),
                'status' => $this->request->getPost('status'),
            ];

            $this->inventoryModel->update($id, $data);

            return redirect()->to('/admin/inventory')->with('success', 'Inventory item updated successfully.');
        }

        $data = [
            'title' => 'Edit Inventory',
            'pageTitle' => 'Edit Inventory Item',
            'item' => $item,
        ];

        return view('admin/inventory/edit', $data);
    }

    public function delete($id)
    {
        $item = $this->inventoryModel->find($id);

        if (!$item) {
            return redirect()->to('/admin/inventory')->with('error', 'Inventory item not found.');
        }

        $this->inventoryModel->delete($id);

        return redirect()->to('/admin/inventory')->with('success', 'Inventory item deleted successfully.');
    }
}
