<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Donation Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Donor Name</label>
                        <p class="mt-1"><?= esc($donation['full_name']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <p class="mt-1">
                            <a href="mailto:<?= esc($donation['email']) ?>" class="text-[#f2b23a] hover:underline"><?= esc($donation['email']) ?></a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Phone</label>
                        <p class="mt-1">
                            <a href="tel:<?= esc($donation['phone']) ?>" class="text-[#f2b23a] hover:underline"><?= esc($donation['phone']) ?></a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Food Type</label>
                        <p class="mt-1"><?= esc($donation['food_type']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Estimated Quantity</label>
                        <p class="mt-1"><?= esc($donation['estimated_quantity']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Preferred Date/Time</label>
                        <p class="mt-1"><?= $donation['preferred_datetime'] ? date('M d, Y H:i', strtotime($donation['preferred_datetime'])) : '-' ?></p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-600">Pickup Address</label>
                        <p class="mt-1"><?= esc($donation['pickup_address']) ?></p>
                    </div>
                    <?php if (!empty($donation['notes'])): ?>
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-gray-600">Notes</label>
                            <p class="mt-1"><?= esc($donation['notes']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($statusHistory)): ?>
            <div class="card bg-white border border-[#e3d6c2] shadow-md">
                <div class="card-body p-6">
                    <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Status History</h3>
                    <div class="space-y-3">
                        <?php foreach (array_reverse($statusHistory) as $history): ?>
                            <div class="flex items-start gap-3 p-3 bg-[#fffaf2] rounded-lg border border-[#e3d6c2]">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-[#f2b23a] text-black"><?= ucfirst(str_replace('_', ' ', $history['status'])) ?></span>
                                        <span class="text-sm text-gray-600">by <?= esc($history['changed_by']) ?></span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1"><?= date('M d, Y H:i', strtotime($history['changed_at'])) ?></div>
                                    <?php if (!empty($history['notes'])): ?>
                                        <div class="text-sm mt-2 text-gray-700"><?= esc($history['notes']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="space-y-6">
        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Update Status</h3>
                <form id="statusForm" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $donation['id'] ?>">
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Status</span></label>
                        <select name="status" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                            <option value="pending" <?= ($donation['status'] ?? 'pending') === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="confirmed" <?= ($donation['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="scheduled" <?= ($donation['status'] ?? '') === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                            <option value="picked_up" <?= ($donation['status'] ?? '') === 'picked_up' ? 'selected' : '' ?>>Picked Up</option>
                            <option value="completed" <?= ($donation['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= ($donation['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Notes</span></label>
                        <textarea name="notes" rows="3" class="textarea textarea-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Add notes..."></textarea>
                    </div>
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f] w-full">Update Status</button>
                </form>
            </div>
        </div>

        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Assignment</h3>
                <form id="assignForm" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $donation['id'] ?>">
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Scheduled Time</span></label>
                        <input type="datetime-local" name="scheduled_time" value="<?= $donation['scheduled_time'] ? date('Y-m-d\TH:i', strtotime($donation['scheduled_time'])) : '' ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                    </div>
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f] w-full">Save Assignment</button>
                </form>
            </div>
        </div>

        <div class="card bg-white border border-[#e3d6c2] shadow-md">
            <div class="card-body p-6">
                <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Current Status</h3>
                <?php
                $status = $donation['status'] ?? 'pending';
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
                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold <?= $class ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('statusForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('<?= site_url('admin/donations/update-status') ?>', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error updating status');
        }
    } catch (error) {
        alert('Error updating status');
    }
});

document.getElementById('assignForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('<?= site_url('admin/donations/assign') ?>', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error updating assignment');
        }
    } catch (error) {
        alert('Error updating assignment');
    }
});
</script>

<?= $this->endSection() ?>
