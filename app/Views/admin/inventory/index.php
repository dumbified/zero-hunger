<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Alerts -->
<?php if (!empty($expiringSoon)): ?>
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-6">
        <strong class="font-bold">Warning:</strong> You have <?= count($expiringSoon) ?> items expiring in the next 7 days.
    </div>
<?php endif; ?>

<?php if (!empty($expired)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <strong class="font-bold">Alert:</strong> You have <?= count($expired) ?> expired items that need attention.
    </div>
<?php endif; ?>

<!-- Filters and Actions -->
<div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
    <div class="card-body p-6">
        <div class="flex items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-bold text-[#4a3b2a]">Inventory Filters</h3>
        </div>
        <?php
        $statusLabel = $currentStatus === 'all' ? 'All Statuses' : ucfirst($currentStatus);
        $expiringValue = (string)($expiring ?? '');
        $expiringLabel = 'All Items';
        if ($expiringValue === '3') {
            $expiringLabel = 'Next 3 days';
        } elseif ($expiringValue === '7') {
            $expiringLabel = 'Next 7 days';
        } elseif ($expiringValue === '14') {
            $expiringLabel = 'Next 14 days';
        }
        ?>
        <form method="get" action="<?= site_url('admin/inventory') ?>" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="status" id="statusValue" value="<?= esc($currentStatus) ?>">
            <input type="hidden" name="expiring" id="expiringValue" value="<?= esc($expiringValue) ?>">
            <div class="flex-1 min-w-[240px]">
                <label class="label p-0 mb-2">
                    <span class="label-text text-sm font-semibold">Search</span>
                </label>
                <input
                    type="text"
                    name="search"
                    value="<?= esc($search ?? '') ?>"
                    placeholder="Search by food type or location..."
                    class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]"
                >
            </div>
            <div class="min-w-[180px]">
                <label class="label p-0 mb-2">
                    <span class="label-text text-sm font-semibold">Status</span>
                </label>
                <div class="dropdown w-full">
                    <label tabindex="0" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] w-full justify-between normal-case">
                        <span class="truncate" id="statusLabel"><?= esc($statusLabel) ?></span>
                    </label>
                    <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-[50] w-52 p-2 shadow">
                        <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="all">All Statuses</button></li>
                        <?php foreach ($statuses as $s): ?>
                            <?php if ($s !== 'all'): ?>
                                <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="<?= $s ?>"><?= ucfirst($s) ?></button></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="min-w-[180px]">
                <label class="label p-0 mb-2">
                    <span class="label-text text-sm font-semibold">Expiring</span>
                </label>
                <div class="dropdown w-full">
                    <label tabindex="0" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] w-full justify-between normal-case">
                        <span class="truncate" id="expiringLabel"><?= esc($expiringLabel) ?></span>
                    </label>
                    <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-[50] w-52 p-2 shadow">
                        <li><button type="button" class="justify-start w-full text-left" data-filter="expiring" data-value="">All Items</button></li>
                        <li><button type="button" class="justify-start w-full text-left" data-filter="expiring" data-value="3">Next 3 days</button></li>
                        <li><button type="button" class="justify-start w-full text-left" data-filter="expiring" data-value="7">Next 7 days</button></li>
                        <li><button type="button" class="justify-start w-full text-left" data-filter="expiring" data-value="14">Next 14 days</button></li>
                    </ul>
                </div>
            </div>
            <div class="flex">
                <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">
                    Filter
                </button>
            </div>
        </form>
        <!-- Inventory is auto-populated from picked up donations, so no manual add button -->
    </div>
</div>

<!-- Inventory Table -->
<div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
    <div class="p-6 border-b border-[#e3d6c2]">
        <h3 class="text-xl font-bold">Inventory Items</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#efe0c9]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Food Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Donor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Expiration Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Storage Location</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e3d6c2] text-sm">
                <?php if (empty($inventory)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No inventory items found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inventory as $item): ?>
                        <?php
                        $expDate = $item['expiration_date'];
                        $isExpiring = false;
                        $isExpired = false;
                        $expiringClass = '';
                        
                        if ($expDate) {
                            $daysUntilExpiry = (strtotime($expDate) - time()) / (60 * 60 * 24);
                            if ($daysUntilExpiry < 0) {
                                $isExpired = true;
                                $expiringClass = 'text-red-600 font-bold';
                            } elseif ($daysUntilExpiry <= 7) {
                                $isExpiring = true;
                                $expiringClass = 'text-orange-600 font-semibold';
                            }
                        }
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><?= str_pad($item['id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-6 py-4"><?= esc($item['food_type']) ?></td>
                            <td class="px-6 py-4"><?= esc($item['donor_name'] ?? '—') ?></td>
                            <td class="px-6 py-4"><?= number_format($item['quantity'], 2) ?> <?= esc($item['unit']) ?></td>
                            <td class="px-6 py-4 <?= $expiringClass ?>">
                                <?= $expDate ? date('M d, Y', strtotime($expDate)) : '-' ?>
                                <?php if ($isExpired): ?>
                                    <span class="text-xs text-red-600">(Expired)</span>
                                <?php elseif ($isExpiring): ?>
                                    <span class="text-xs text-orange-600">(Soon)</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4"><?= esc($item['storage_location'] ?? '-') ?></td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $item['status'] ?? 'unknown';
                                $statusText = $status ? ucfirst($status) : 'Unknown';
                                $statusClass = [
                                    'available' => 'bg-green-100 text-green-800',
                                    'reserved' => 'bg-blue-100 text-blue-800',
                                    'distributed' => 'bg-gray-100 text-gray-800',
                                    'expired' => 'bg-red-100 text-red-800',
                                ];
                                $class = $statusClass[$status] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>">
                                    <?= esc($statusText) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="<?= site_url('admin/inventory/edit/' . $item['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">
                                        Edit
                                    </a>
                                    <a href="<?= site_url('admin/inventory/delete/' . $item['id']) ?>" 
                                       class="text-red-600 hover:underline text-sm"
                                       onclick="return confirm('Are you sure you want to delete this item?')">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager->hasMore('inventory')): ?>
        <div class="p-6 border-t border-[#e3d6c2]">
            <?= $pager->links('inventory', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('[data-filter]').forEach((button) => {
        button.addEventListener('click', () => {
            const type = button.getAttribute('data-filter');
            const value = button.getAttribute('data-value');
            const labelText = button.textContent.trim();
            if (type === 'status') {
                document.getElementById('statusValue').value = value;
                document.getElementById('statusLabel').textContent = labelText;
            } else if (type === 'expiring') {
                document.getElementById('expiringValue').value = value;
                document.getElementById('expiringLabel').textContent = labelText;
            }
            const dropdown = button.closest('.dropdown');
            if (dropdown) {
                const trigger = dropdown.querySelector('[tabindex="0"]');
                if (trigger) {
                    trigger.blur();
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
