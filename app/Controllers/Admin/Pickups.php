<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DonationModel;
use App\Models\UserModel;

class Pickups extends BaseController
{
    protected $donationModel;
    protected $userModel;

    public function __construct()
    {
        $this->donationModel = new DonationModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $view = $this->request->getGet('view') ?? 'month';
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        // Get scheduled pickups
        $scheduledPickups = $this->donationModel->where('status', 'scheduled')
            ->orWhere('status', 'confirmed')
            ->where('scheduled_time IS NOT NULL')
            ->orderBy('scheduled_time', 'ASC')
            ->findAll();

        // Get today's pickups
        $todayPickups = $this->donationModel->where('DATE(scheduled_time)', date('Y-m-d'))
            ->where('status', 'scheduled')
            ->orderBy('scheduled_time', 'ASC')
            ->findAll();

        // Get drivers
        $drivers = $this->userModel->where('role', 'driver')
            ->orWhere('role', 'admin')
            ->where('status', 'active')
            ->findAll();

        $data = [
            'title' => 'Pickups',
            'pageTitle' => 'Pickup Scheduling',
            'view' => $view,
            'date' => $date,
            'scheduledPickups' => $scheduledPickups,
            'todayPickups' => $todayPickups,
            'drivers' => $drivers,
        ];

        return view('admin/pickups/index', $data);
    }

    public function schedule()
    {
        $donationId = $this->request->getPost('donation_id');
        $scheduledTime = $this->request->getPost('scheduled_time');
        $assignedDriver = $this->request->getPost('assigned_driver');

        $donation = $this->donationModel->find($donationId);
        if (!$donation) {
            return $this->response->setJSON(['success' => false, 'message' => 'Donation not found.']);
        }

        $updateData = [
            'status' => 'scheduled',
            'scheduled_time' => $scheduledTime,
        ];

        if ($assignedDriver) {
            $updateData['assigned_driver'] = $assignedDriver;
        }

        // Update status history
        $statusHistory = [];
        if (!empty($donation['status_history'])) {
            $statusHistory = json_decode($donation['status_history'], true) ?? [];
        }

        $statusHistory[] = [
            'status' => 'scheduled',
            'changed_by' => session()->get('admin_username'),
            'changed_at' => date('Y-m-d H:i:s'),
            'notes' => 'Scheduled for pickup',
        ];

        $updateData['status_history'] = json_encode($statusHistory);

        $this->donationModel->update($donationId, $updateData);

        return $this->response->setJSON(['success' => true, 'message' => 'Pickup scheduled successfully.']);
    }
}
