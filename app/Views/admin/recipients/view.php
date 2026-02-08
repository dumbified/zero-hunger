<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#4a3b2a]">Recipient Information</h3>
                    <a href="<?= site_url('admin/recipients/edit/' . $recipient['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">Edit</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Name</label>
                        <p class="mt-1"><?= esc($recipient['name']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Type</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800"><?= ucfirst($recipient['type']) ?></span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Contact Information</label>
                        <p class="mt-1"><?= esc($recipient['contact_info'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Address</label>
                        <p class="mt-1"><?= esc($recipient['address'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Service Area</label>
                        <p class="mt-1"><?= esc($recipient['service_area'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Status</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $recipient['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>"><?= ucfirst($recipient['status']) ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#4a3b2a]">Distribution History</h3>
                    <a href="<?= site_url('admin/recipients/add-distribution?recipient_id=' . $recipient['id']) ?>" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f] text-sm">+ Record Distribution</a>
                </div>
                <?php if (empty($distributions)): ?>
                    <p class="text-gray-500">No distributions recorded yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($distributions as $distribution): ?>
                            <?php $items = json_decode($distribution['items'], true) ?? []; ?>
                            <div class="border border-[#e3d6c2] rounded-lg p-4 bg-[#fffaf2]">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold"><?= date('M d, Y', strtotime($distribution['date'])) ?></span>
                                    <?php if ($distribution['delivery_method']): ?>
                                        <span class="text-sm text-gray-600"><?= esc($distribution['delivery_method']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm text-gray-700">
                                    <?php foreach ($items as $item): ?>
                                        <div>• <?= esc($item['food_type'] ?? 'Unknown') ?> - <?php $q = (float)($item['quantity'] ?? 0); echo $q == (int)$q ? (string)(int)$q : number_format($q, 2); ?> <?= esc($item['unit'] ?? '') ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if ($distribution['notes']): ?>
                                    <div class="mt-2 text-sm text-gray-600"><?= esc($distribution['notes']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="<?= site_url('admin/recipients/add-distribution?recipient_id=' . $recipient['id']) ?>" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f] w-full">Record Distribution</a>
                    <a href="<?= site_url('admin/recipients/edit/' . $recipient['id']) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9] w-full">Edit Recipient</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
