<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RecipientModel;
use App\Models\DistributionModel;
use App\Models\InventoryModel;

class Recipients extends BaseController
{
    protected $recipientModel;
    protected $distributionModel;
    protected $inventoryModel;

    public function __construct()
    {
        $this->recipientModel = new RecipientModel();
        $this->distributionModel = new DistributionModel();
        $this->inventoryModel = new InventoryModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;

        $builder = $this->recipientModel->builder();

        if ($status && $status !== 'all') {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('contact_info', $search)
                ->orLike('address', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $recipients = $builder->orderBy('created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        $pager = \Config\Services::pager();
        $pager->store('recipients', $page, $perPage, $total);

        $data = [
            'title' => 'Recipients',
            'pageTitle' => 'Recipient Management',
            'recipients' => $recipients,
            'pager' => $pager,
            'currentStatus' => $status ?? 'all',
            'search' => $search,
        ];

        return view('admin/recipients/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|max_length[255]',
                'type' => 'required|in_list[individual,organization]',
                'contact_info' => 'permit_empty',
                'address' => 'permit_empty|max_length[255]',
                'service_area' => 'permit_empty|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'type' => $this->request->getPost('type'),
                'contact_info' => $this->request->getPost('contact_info'),
                'address' => $this->request->getPost('address'),
                'service_area' => $this->request->getPost('service_area'),
                'status' => 'active',
            ];

            $this->recipientModel->insert($data);

            return redirect()->to('/admin/recipients')->with('success', 'Recipient added successfully.');
        }

        $data = [
            'title' => 'Add Recipient',
            'pageTitle' => 'Add Recipient',
        ];

        return view('admin/recipients/add', $data);
    }

    public function view($id)
    {
        $recipient = $this->recipientModel->find($id);

        if (!$recipient) {
            return redirect()->to('/admin/recipients')->with('error', 'Recipient not found.');
        }

        $distributions = $this->distributionModel->getDistributionsByRecipient($id);

        $data = [
            'title' => 'View Recipient',
            'pageTitle' => 'Recipient Details',
            'recipient' => $recipient,
            'distributions' => $distributions,
        ];

        return view('admin/recipients/view', $data);
    }

    public function edit($id)
    {
        $recipient = $this->recipientModel->find($id);

        if (!$recipient) {
            return redirect()->to('/admin/recipients')->with('error', 'Recipient not found.');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|max_length[255]',
                'type' => 'required|in_list[individual,organization]',
                'contact_info' => 'permit_empty',
                'address' => 'permit_empty|max_length[255]',
                'service_area' => 'permit_empty|max_length[100]',
                'status' => 'required|in_list[active,inactive]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'type' => $this->request->getPost('type'),
                'contact_info' => $this->request->getPost('contact_info'),
                'address' => $this->request->getPost('address'),
                'service_area' => $this->request->getPost('service_area'),
                'status' => $this->request->getPost('status'),
            ];

            $this->recipientModel->update($id, $data);

            return redirect()->to('/admin/recipients')->with('success', 'Recipient updated successfully.');
        }

        $data = [
            'title' => 'Edit Recipient',
            'pageTitle' => 'Edit Recipient',
            'recipient' => $recipient,
        ];

        return view('admin/recipients/edit', $data);
    }

    public function addDistribution()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'recipient_id' => 'required|integer',
                'items' => 'required',
                'date' => 'required|valid_date',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $items = json_decode($this->request->getPost('items'), true);
            
            // Update inventory status
            foreach ($items as $item) {
                if (isset($item['inventory_id'])) {
                    $this->inventoryModel->update($item['inventory_id'], [
                        'status' => 'distributed',
                        'quantity' => $this->inventoryModel->find($item['inventory_id'])['quantity'] - ($item['quantity'] ?? 0),
                    ]);
                }
            }

            $data = [
                'recipient_id' => $this->request->getPost('recipient_id'),
                'items' => $this->request->getPost('items'),
                'date' => $this->request->getPost('date'),
                'delivery_method' => $this->request->getPost('delivery_method'),
                'notes' => $this->request->getPost('notes'),
            ];

            $this->distributionModel->insert($data);

            return redirect()->to('/admin/recipients/view/' . $this->request->getPost('recipient_id'))->with('success', 'Distribution recorded successfully.');
        }

        $recipientId = $this->request->getGet('recipient_id');
        $recipient = $this->recipientModel->find($recipientId);
        
        if (!$recipient) {
            return redirect()->to('/admin/recipients')->with('error', 'Recipient not found.');
        }

        $availableInventory = $this->inventoryModel->where('status', 'available')->findAll();

        $data = [
            'title' => 'Add Distribution',
            'pageTitle' => 'Record Distribution',
            'recipient' => $recipient,
            'availableInventory' => $availableInventory,
        ];

        return view('admin/recipients/add_distribution', $data);
    }
}
