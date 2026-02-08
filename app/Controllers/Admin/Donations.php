<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DonationModel;
use App\Models\UserModel;
use App\Models\InventoryModel;

class Donations extends BaseController
{
    protected $donationModel;
    protected $userModel;
    protected $inventoryModel;

    public function __construct()
    {
        $this->donationModel  = new DonationModel();
        $this->userModel      = new UserModel();
        $this->inventoryModel = new InventoryModel();
    }

    public function index()
    {
        $donorEmail = $this->request->getGet('donor_email');
        $search = $this->request->getGet('search');
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;

        // Viewing one donor's donations (list of donation records for that email)
        if ($donorEmail !== null && $donorEmail !== '') {
            $donations = $this->donationModel
                ->where('email', $donorEmail)
                ->orderBy('created_at', 'DESC')
                ->paginate($perPage, 'donations');
            $pager = $this->donationModel->pager;
            $donorName = $donations[0]['full_name'] ?? $donorEmail;
            if (empty($donations)) {
                $donorName = $donorEmail;
            }
            $data = [
                'title' => 'Donations',
                'pageTitle' => 'Donation Management',
                'viewDonorEmail' => $donorEmail,
                'viewDonorName' => $donorName,
                'donations' => $donations,
                'pager' => $pager,
                'currentStatus' => 'all',
                'search' => '',
                'statuses' => ['all', 'pending', 'confirmed', 'scheduled', 'picked_up', 'completed', 'cancelled'],
            ];
            return view('admin/donations/index', $data);
        }

        // Unique donors list (group by email)
        $db = \Config\Database::connect();
        $builder = $this->donationModel->builder();
        $builder->select('full_name, email, phone, COUNT(*) as donation_count');
        $builder->groupBy('email');

        if ($search) {
            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        $compiled = $builder->getCompiledSelect(false);
        $countSql = "SELECT COUNT(*) as cnt FROM ($compiled) sub";
        $total = (int) $db->query($countSql)->getRow()->cnt;

        $builder->orderBy('full_name', 'ASC');
        $donors = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        $pager = \Config\Services::pager();
        $pager->store('donations', $page, $perPage, $total);

        $data = [
            'title' => 'Donors',
            'pageTitle' => 'Donors',
            'viewDonorEmail' => null,
            'donors' => $donors,
            'donations' => [],
            'pager' => $pager,
            'currentStatus' => 'all',
            'search' => $search,
            'statuses' => ['all', 'pending', 'confirmed', 'scheduled', 'picked_up', 'completed', 'cancelled'],
        ];

        return view('admin/donations/index', $data);
    }

    public function view($id)
    {
        $donation = $this->donationModel->find($id);

        if (!$donation) {
            return redirect()->to('/admin/donations')->with('error', 'Donation not found.');
        }

        // Get assigned user if exists
        $assignedUser = null;
        if (!empty($donation['assigned_to'])) {
            $assignedUser = $this->userModel->find($donation['assigned_to']);
        }

        // Get assigned driver if exists
        $assignedDriver = null;
        if (!empty($donation['assigned_driver'])) {
            $assignedDriver = $this->userModel->find($donation['assigned_driver']);
        }

        // Parse status history
        $statusHistory = [];
        if (!empty($donation['status_history'])) {
            $statusHistory = json_decode($donation['status_history'], true) ?? [];
        }

        $data = [
            'title' => 'View Donation',
            'pageTitle' => 'Donation Details',
            'donation' => $donation,
            'assignedUser' => $assignedUser,
            'assignedDriver' => $assignedDriver,
            'statusHistory' => $statusHistory,
        ];

        return view('admin/donations/view', $data);
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        $donation = $this->donationModel->find($id);
        if (!$donation) {
            return $this->response->setJSON(['success' => false, 'message' => 'Donation not found.']);
        }

        // Get current status history
        $statusHistory = [];
        if (!empty($donation['status_history'])) {
            $statusHistory = json_decode($donation['status_history'], true) ?? [];
        }

        // Add new status entry
        $statusHistory[] = [
            'status' => $status,
            'changed_by' => session()->get('admin_username'),
            'changed_at' => date('Y-m-d H:i:s'),
            'notes' => $notes,
        ];

        $updateData = [
            'status' => $status,
            'status_history' => json_encode($statusHistory),
        ];

        if ($notes) {
            $updateData['internal_notes'] = $donation['internal_notes'] 
                ? $donation['internal_notes'] . "\n" . date('Y-m-d H:i:s') . ': ' . $notes
                : date('Y-m-d H:i:s') . ': ' . $notes;
        }

        $this->donationModel->update($id, $updateData);

        // When a donation is picked up or completed, create inventory entry if not already created
        if (in_array($status, ['picked_up', 'completed'], true)) {
            $this->createInventoryFromDonation($donation);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully.']);
    }

    /**
     * Create an inventory record from a donation if one does not already exist.
     */
    protected function createInventoryFromDonation(array $donation): void
    {
        if (empty($donation['id'])) {
            return;
        }

        // Avoid creating duplicate inventory rows for the same donation
        $existing = $this->inventoryModel
            ->where('donation_id', $donation['id'])
            ->first();

        if ($existing) {
            return;
        }

        $quantity = isset($donation['estimated_quantity']) && is_numeric($donation['estimated_quantity'])
            ? (float) $donation['estimated_quantity']
            : 0;

        $this->inventoryModel->insert([
            'donation_id'      => $donation['id'],
            'food_type'        => $donation['food_type'] ?? 'Unknown',
            'quantity'         => $quantity,
            'unit'             => 'kg',
            'expiration_date'  => null,
            'storage_location' => null,
            'status'           => 'available',
        ]);
    }

    public function assign()
    {
        $id = $this->request->getPost('id');
        $assignedTo = $this->request->getPost('assigned_to');
        $assignedDriver = $this->request->getPost('assigned_driver');
        $scheduledTime = $this->request->getPost('scheduled_time');

        $donation = $this->donationModel->find($id);
        if (!$donation) {
            return $this->response->setJSON(['success' => false, 'message' => 'Donation not found.']);
        }

        $updateData = [];
        if ($assignedTo !== null) {
            $updateData['assigned_to'] = $assignedTo ?: null;
        }
        if ($assignedDriver !== null) {
            $updateData['assigned_driver'] = $assignedDriver ?: null;
        }
        if ($scheduledTime) {
            $updateData['scheduled_time'] = $scheduledTime;
        }

        $this->donationModel->update($id, $updateData);

        return $this->response->setJSON(['success' => true, 'message' => 'Assignment updated successfully.']);
    }

    public function export()
    {
        $search = $this->request->getGet('search');

        $builder = $this->donationModel->builder();
        $builder->select('full_name, email, phone, COUNT(*) as donation_count');
        $builder->groupBy('email');

        if ($search) {
            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        $donors = $builder->orderBy('full_name', 'ASC')->get()->getResultArray();

        $filename = 'donors_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Donor Name', 'Email', 'Phone', 'Donation Count']);

        foreach ($donors as $donor) {
            fputcsv($output, [
                $donor['full_name'],
                $donor['email'],
                $donor['phone'],
                $donor['donation_count'],
            ]);
        }

        fclose($output);
        exit;
    }
}
