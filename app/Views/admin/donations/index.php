<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Filters and Actions -->
<div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
    <div class="card-body p-6">
        <div class="flex items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-bold text-[#4a3b2a]">Donors Filters</h3>
        </div>
        <?php
        $statusLabel = $currentStatus === 'all' ? 'All Statuses' : ucfirst(str_replace('_', ' ', $currentStatus));
        ?>
        <form method="get" action="<?= site_url('admin/donations') ?>" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="status" id="statusValue" value="<?= esc($currentStatus) ?>">
            <div class="flex-1 min-w-[240px]">
                <label class="label p-0 mb-2">
                    <span class="label-text text-sm font-semibold">Search</span>
                </label>
                <input
                    type="text"
                    name="search"
                    value="<?= esc($search ?? '') ?>"
                    placeholder="Search by name, email, phone, or food type..."
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
                                <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="<?= $s ?>"><?= ucfirst(str_replace('_', ' ', $s)) ?></button></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">
                    Filter
                </button>
                <a href="<?= site_url('admin/donations/export?' . http_build_query(['status' => $currentStatus, 'search' => $search ?? ''])) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">
                    Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Donations Table -->
<div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
    <div class="p-6 border-b border-[#e3d6c2]">
        <h3 class="text-xl font-bold">Donors & Food Donations</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#efe0c9]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Donor Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Contact Info</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Food Details</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Preferred Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e3d6c2] text-sm">
                <?php if (empty($donations)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No donations found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($donations as $donation): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><?= str_pad($donation['id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-base"><?= esc($donation['full_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="mb-1"><?= esc($donation['email']) ?></div>
                                <div class="text-gray-600"><?= esc($donation['phone']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-base text-[#f2b23a]"><?= esc($donation['food_type']) ?></div>
                                <?php if (!empty($donation['notes'])): ?>
                                    <div class="text-xs text-gray-500 mt-1"><?= esc(substr($donation['notes'], 0, 50)) ?><?= strlen($donation['notes']) > 50 ? '...' : '' ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4"><?= esc($donation['estimated_quantity']) ?></td>
                            <td class="px-6 py-4 text-sm">
                                <?= $donation['preferred_datetime'] ? date('M d, Y H:i', strtotime($donation['preferred_datetime'])) : '-' ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $donation['status'] ?? 'pending';
                                $statusText = $status ? ucfirst(str_replace('_', ' ', $status)) : 'Unknown';
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
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>">
                                    <?= esc($statusText) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?= site_url('admin/donations/view/' . $donation['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager->hasMore('donations')): ?>
        <div class="p-6 border-t border-[#e3d6c2]">
            <?= $pager->links('donations', 'default_full') ?>
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
