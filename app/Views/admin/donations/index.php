<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (!empty($viewDonorEmail)): ?>
    <!-- Viewing one donor's donations -->
    <div class="mb-4">
        <a href="<?= site_url('admin/donations') ?>" class="text-[#f2b23a] hover:underline text-sm">← Back to Donors</a>
    </div>
    <div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
        <div class="card-body p-6">
            <h3 class="text-lg font-bold text-[#4a3b2a]">Donations from <?= esc($viewDonorName) ?></h3>
            <p class="text-sm text-gray-600"><?= esc($viewDonorEmail) ?></p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
        <div class="p-6 border-b border-[#e3d6c2]">
            <h3 class="text-xl font-bold">Donation records</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#efe0c9]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Food / Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Preferred date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3d6c2] text-sm">
                    <?php if (empty($donations)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No donations from this donor.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($donations as $donation): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><?= str_pad($donation['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-medium"><?= esc($donation['food_type']) ?></div>
                                    <div class="text-gray-600"><?= esc($donation['estimated_quantity']) ?></div>
                                </td>
                                <td class="px-6 py-4"><?= $donation['preferred_datetime'] ? date('M d, Y H:i', strtotime($donation['preferred_datetime'])) : '-' ?></td>
                                <td class="px-6 py-4">
                                    <?php
                                    $status = $donation['status'] ?? 'pending';
                                    $statusText = ucfirst(str_replace('_', ' ', $status));
                                    $statusClass = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'scheduled' => 'bg-purple-100 text-purple-800',
                                        'picked_up' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-green-200 text-green-900',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $class = $statusClass[$status] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>"><?= esc($statusText) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="<?= site_url('admin/donations/view/' . $donation['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pager) && $pager->hasMore('donations')): ?>
            <div class="p-6 border-t border-[#e3d6c2]"><?= $pager->links('donations', 'default_full') ?></div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Unique donors list -->
    <div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
        <div class="card-body p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-lg font-bold text-[#4a3b2a]">Donors</h3>
            </div>
            <form method="get" action="<?= site_url('admin/donations') ?>" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[240px]">
                    <label class="label p-0 mb-2">
                        <span class="label-text text-sm font-semibold">Search</span>
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Search by name, email, or phone..."
                        class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]"
                    >
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Search</button>
                    <a href="<?= site_url('admin/donations/export?' . http_build_query(['search' => $search ?? ''])) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Export CSV</a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
        <div class="p-6 border-b border-[#e3d6c2]">
            <h3 class="text-xl font-bold">Donors</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#efe0c9]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Donor name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Donations</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3d6c2] text-sm">
                    <?php if (empty($donors)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No donors found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($donors as $donor): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold"><?= esc($donor['full_name']) ?></td>
                                <td class="px-6 py-4">
                                    <a href="mailto:<?= esc($donor['email']) ?>" class="text-[#f2b23a] hover:underline"><?= esc($donor['email']) ?></a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="tel:<?= esc($donor['phone']) ?>" class="text-[#f2b23a] hover:underline"><?= esc($donor['phone']) ?></a>
                                </td>
                                <td class="px-6 py-4"><?= (int) $donor['donation_count'] ?></td>
                                <td class="px-6 py-4">
                                    <a href="<?= site_url('admin/donations?' . http_build_query(['donor_email' => $donor['email']])) ?>" class="text-[#f2b23a] hover:underline text-sm">View donations</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($pager->hasMore('donations')): ?>
            <div class="p-6 border-t border-[#e3d6c2]"><?= $pager->links('donations', 'default_full') ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
