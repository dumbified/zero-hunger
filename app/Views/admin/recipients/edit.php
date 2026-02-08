<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl">
    <div class="card bg-white border border-[#e3d6c2] shadow-md">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-6">Edit Recipient</h3>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/recipients/edit/' . $recipient['id']) ?>" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Name *</span></label>
                    <input type="text" name="name" value="<?= old('name', $recipient['name']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Type *</span></label>
                    <select name="type" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="individual" <?= $recipient['type'] === 'individual' ? 'selected' : '' ?>>Individual</option>
                        <option value="organization" <?= $recipient['type'] === 'organization' ? 'selected' : '' ?>>Organization</option>
                    </select>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Contact Information</span></label>
                    <textarea name="contact_info" rows="3" class="textarea textarea-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]"><?= old('contact_info', $recipient['contact_info']) ?></textarea>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Address</span></label>
                    <input type="text" name="address" value="<?= old('address', $recipient['address']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Service Area</span></label>
                    <input type="text" name="service_area" value="<?= old('service_area', $recipient['service_area']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Status *</span></label>
                    <select name="status" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="active" <?= $recipient['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $recipient['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Update Recipient</button>
                    <a href="<?= site_url('admin/recipients/view/' . $recipient['id']) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
