<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Filters and Actions -->
<div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
    <div class="card-body p-6">
        <div class="flex items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-bold text-[#4a3b2a]">Beneficiaries Filters</h3>
        </div>
        <?php
        $statusLabel = $currentStatus === 'all' ? 'All' : ucfirst($currentStatus);
        ?>
        <form method="get" action="<?= site_url('admin/recipients') ?>" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="status" id="statusValue" value="<?= esc($currentStatus) ?>">
            <div class="flex-1 min-w-[240px]">
                <label class="label p-0 mb-2">
                    <span class="label-text text-sm font-semibold">Search</span>
                </label>
                <input
                    type="text"
                    name="search"
                    value="<?= esc($search ?? '') ?>"
                    placeholder="Search by name, contact, or address..."
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
                        <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="all">All</button></li>
                        <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="active">Active</button></li>
                        <li><button type="button" class="justify-start w-full text-left" data-filter="status" data-value="inactive">Inactive</button></li>
                    </ul>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">
                    Filter
                </button>
                <a href="<?= site_url('admin/recipients/add') ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">
                    + Add Recipient
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Recipients Table -->
<div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
    <div class="p-6 border-b border-[#e3d6c2]">
        <h3 class="text-xl font-bold">Beneficiaries</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#efe0c9]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e3d6c2] text-sm">
                <?php if (empty($recipients)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No recipients found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recipients as $recipient): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold"><?= esc($recipient['name']) ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                    <?= ucfirst($recipient['type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm"><?= esc($recipient['contact_info'] ?? '-') ?></td>
                            <td class="px-6 py-4 text-sm"><?= esc($recipient['address'] ?? '-') ?></td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $recipient['status'] ?? 'unknown';
                                $statusText = $status ? ucfirst($status) : 'Unknown';
                                $class = $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>">
                                    <?= esc($statusText) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="<?= site_url('admin/recipients/view/' . $recipient['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">
                                        View
                                    </a>
                                    <a href="<?= site_url('admin/recipients/edit/' . $recipient['id']) ?>" class="text-blue-600 hover:underline text-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager->hasMore('recipients')): ?>
        <div class="p-6 border-t border-[#e3d6c2]">
            <?= $pager->links('recipients', 'default_full') ?>
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
