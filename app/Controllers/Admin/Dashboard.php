<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DonationModel;
use App\Models\UserModel;

class Dashboard extends BaseController
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
        $db = \Config\Database::connect();
        
        // Get statistics
        $stats = [
            'total_donations_month' => $this->donationModel->where('MONTH(created_at)', date('m'))
                ->where('YEAR(created_at)', date('Y'))
                ->countAllResults(false),
            'pending_pickups' => $this->donationModel->where('status', 'pending')
                ->orWhere('status', 'confirmed')
                ->orWhere('status', 'scheduled')
                ->countAllResults(false),
            'active_inventory' => $db->table('inventory')
                ->where('status', 'available')
                ->countAllResults(),
            'expiring_soon' => $db->table('inventory')
                ->where('expiration_date >=', date('Y-m-d'))
                ->where('expiration_date <=', date('Y-m-d', strtotime('+7 days')))
                ->where('status', 'available')
                ->countAllResults(),
            'total_users' => $this->userModel->where('status', 'active')->countAllResults(false),
        ];

        // Get recent donations
        $recentDonations = $this->donationModel->orderBy('created_at', 'DESC')
            ->limit(10)
            ->findAll();

        // Get donation status breakdown
        $statusBreakdown = $db->table('donations')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResultArray();

        // Top 5 inventory items expiring in the next 7 days
        $expiringSoon = $db->table('inventory')
            ->where('expiration_date >=', date('Y-m-d'))
            ->where('expiration_date <=', date('Y-m-d', strtotime('+7 days')))
            ->where('status', 'available')
            ->orderBy('expiration_date', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard Overview',
            'stats' => $stats,
            'recentDonations' => $recentDonations,
            'statusBreakdown' => $statusBreakdown,
            'expiringSoon' => $expiringSoon,
        ];

        return view('admin/dashboard', $data);
    }
}
