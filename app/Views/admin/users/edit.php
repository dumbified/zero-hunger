<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl">
    <div class="card bg-white border border-[#e3d6c2] shadow-md">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-6">Edit User</h3>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Username *</span></label>
                    <input type="text" name="username" value="<?= old('username', $user['username']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Email *</span></label>
                    <input type="email" name="email" value="<?= old('email', $user['email']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Password (leave blank to keep current)</span></label>
                    <input type="password" name="password" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Role *</span></label>
                    <select name="role" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="viewer" <?= $user['role'] === 'viewer' ? 'selected' : '' ?>>Viewer</option>
                        <option value="driver" <?= $user['role'] === 'driver' ? 'selected' : '' ?>>Driver</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="super_admin" <?= $user['role'] === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Status *</span></label>
                    <select name="status" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Update User</button>
                    <a href="<?= site_url('admin/users') ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
