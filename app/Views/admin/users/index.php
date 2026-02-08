<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
    <div class="p-6 border-b border-[#e3d6c2] flex items-center justify-between">
        <h3 class="text-xl font-bold">Users</h3>
        <a href="<?= site_url('admin/users/add') ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">
            + Add User
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#efe0c9]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Last Login</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e3d6c2] text-sm">
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No users found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold"><?= esc($user['username']) ?></td>
                            <td class="px-6 py-4"><?= esc($user['email']) ?></td>
                            <td class="px-6 py-4">
                                <?php
                                $role = $user['role'] ?? 'unknown';
                                $roleText = $role ? ucfirst(str_replace('_', ' ', $role)) : 'Unknown';
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                    <?= esc($roleText) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $user['status'] ?? 'unknown';
                                $statusText = $status ? ucfirst($status) : 'Unknown';
                                $class = $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>">
                                    <?= esc($statusText) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?= $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never' ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">
                                        Edit
                                    </a>
                                    <?php if ($user['id'] != session()->get('admin_user_id')): ?>
                                        <a href="<?= site_url('admin/users/delete/' . $user['id']) ?>" 
                                           class="text-red-600 hover:underline text-sm"
                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
