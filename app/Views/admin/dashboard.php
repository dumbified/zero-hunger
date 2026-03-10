<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto space-y-8">
    <!-- Overview cards - 4 in one row using DaisyUI cards -->
    <div class="grid grid-cols-4 md:grid-cols-4 xl:grid-cols-4 gap-4">
        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <p class="text-sm text-gray-600">Donors this month</p>
                <h2 class="card-title text-3xl text-[#f2b23a]">
                    <?= number_format($stats['total_donations_month']) ?>
                </h2>
                <p class="text-xs text-gray-500">New donation records</p>
            </div>
        </div>

        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <p class="text-sm text-gray-600">Active inventory</p>
                <h2 class="card-title text-3xl text-[#6cc1f5]">
                    <?= number_format($stats['active_inventory']) ?>
                </h2>
                <p class="text-xs text-gray-500">Available food items</p>
            </div>
        </div>

        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <p class="text-sm text-gray-600">Pending pickups</p>
                <h2 class="card-title text-3xl text-[#f06b5e]">
                    <?= number_format($stats['pending_pickups']) ?>
                </h2>
                <p class="text-xs text-gray-500">Awaiting action</p>
            </div>
        </div>

        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <p class="text-sm text-gray-600">Expiring soon</p>
                <h2 class="card-title text-3xl text-orange-500">
                    <?= number_format($stats['expiring_soon']) ?>
                </h2>
                <p class="text-xs text-gray-500">Next 7 days</p>
            </div>
        </div>
    </div>

    <!-- Donation Status (Chart.js) + Expiring soon list -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <h3 class="card-title mb-2">Donation status</h3>
                <p class="text-xs text-gray-500 mb-4">Current breakdown of all donation records.</p>
                <div class="w-full max-w-md mx-auto">
                    <canvas id="donationStatusChart" aria-label="Donation status chart" role="img"></canvas>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-md border border-[#e3d6c2]">
            <div class="card-body">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="card-title">Expiring soon</h3>
                    <a href="<?= site_url('admin/inventory?expiring=7') ?>" class="text-sm text-[#f2b23a] hover:underline">View all</a>
                </div>
                <?php if (empty($expiringSoon)): ?>
                    <p class="text-sm text-gray-500">No items expiring in the next 7 days.</p>
                <?php else: ?>
                    <ul class="space-y-3">
                        <?php foreach ($expiringSoon as $item): ?>
                            <li class="flex items-center justify-between text-sm border-b border-[#e3d6c2] pb-2 last:border-0 last:pb-0">
                                <span class="font-medium"><?= esc($item['food_type']) ?></span>
                                <span class="text-gray-600"><?= date('M j', strtotime($item['expiration_date'])) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="card bg-white shadow-md border border-[#e3d6c2] mt-6">
        <div class="card-body border-b border-[#e3d6c2] pb-4">
            <div class="flex items-center justify-between">
                <h3 class="card-title">Recent donations</h3>
                <a href="<?= site_url('admin/donations') ?>" class="text-sm text-[#f2b23a] hover:underline">
                    View all →
                </a>
            </div>
        </div>
        <div class="overflow-auto max-h-[60vh] bg-white">
            <table class="table table-sm w-full bg-white">
                <thead class="bg-[#efe0c9]">
                    <tr>
                        <th class="text-center text-xs font-semibold uppercase">ID</th>
                        <th class="text-center text-xs font-semibold uppercase">Donor</th>
                        <th class="text-center text-xs font-semibold uppercase">Food Type</th>
                        <th class="text-center text-xs font-semibold uppercase">Quantity</th>
                        <th class="text-center text-xs font-semibold uppercase">Status</th>
                        <th class="text-center text-xs font-semibold uppercase">Date</th>
                        <th class="text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm bg-white">
                <?php if (empty($recentDonations)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No donations yet
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentDonations as $donation): ?>
                        <tr>
                            <td class="text-center"><?= str_pad($donation['id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td class="text-center font-medium"><?= esc($donation['full_name']) ?></td>
                            <td class="text-center"><?= esc($donation['food_type']) ?></td>
                            <td class="text-center"><?= esc($donation['estimated_quantity']) ?></td>
                            <td class="text-center">
                                <?php
                                $status = $donation['status'] ?? 'pending';
                                $statusClass = [
                                    'pending' => 'badge-warning',
                                    'confirmed' => 'badge-info',
                                    'scheduled' => 'badge-primary',
                                    'picked_up' => 'badge-success',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-error',
                                ];
                                $class = $statusClass[$status] ?? 'badge-ghost';
                                ?>
                                <span class="badge badge-sm <?= $class ?>">
                                    <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                </span>
                            </td>
                            <td class="text-center text-sm"><?= date('M d, Y', strtotime($donation['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('admin/donations/view/' . $donation['id']) ?>" class="link link-warning text-xs">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
// Prepare data for Chart.js
$chartStatusLabels = [];
$chartStatusCounts = [];
foreach ($statusBreakdown as $row) {
    $key = $row['status'];
    $labelMap = [
        'pending'   => 'Pending',
        'confirmed' => 'Confirmed',
        'scheduled' => 'Scheduled',
        'picked_up' => 'Picked Up',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
    $chartStatusLabels[] = $labelMap[$key] ?? ucfirst($key);
    $chartStatusCounts[] = (int) $row['count'];
}
?>

<script>
    (function () {
        const canvas = document.getElementById('donationStatusChart');
        if (!canvas || typeof Chart === 'undefined') return;

        const labels = <?= json_encode($chartStatusLabels) ?>;
        const data = <?= json_encode($chartStatusCounts) ?>;

        const hasData = Array.isArray(data) && data.some((v) => v > 0);
        if (!hasData) {
            canvas.parentElement.innerHTML = '<p class="text-sm text-gray-500 text-center">No donation data available yet.</p>';
            return;
        }

        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: [
                        '#FACC15', // pending
                        '#60A5FA', // confirmed
                        '#A855F7', // scheduled
                        '#4ADE80', // picked up
                        '#22C55E', // completed
                        '#F97373', // cancelled
                    ],
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });
    })();
</script>

</div><!-- /.max-w-6xl -->

<?= $this->endSection() ?>
