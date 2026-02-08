<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap">
    <link rel="stylesheet" href="/global.css">
</head>
<body class="min-h-screen bg-[#efe0c9]">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-brand">
                <img src="<?= base_url('logo.png') ?>" alt="Zero Hunger">
                <div>
                    <span class="sidebar-brand-text">Zero Hunger</span>
                    <span class="sidebar-brand-sub">Admin</span>
                </div>
            </div>

            <nav>
                <div class="nav-label">Main</div>
                <ul>
                    <li>
                        <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-link<?= uri_string() == 'admin/dashboard' || uri_string() == 'admin' ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Overview</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('admin/inventory') ?>" class="sidebar-link<?= strpos(uri_string(), 'admin/inventory') === 0 ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('admin/donations') ?>" class="sidebar-link<?= strpos(uri_string(), 'admin/donations') === 0 ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Donors</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('admin/pickups') ?>" class="sidebar-link<?= strpos(uri_string(), 'admin/pickups') === 0 ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <span>Pickups</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('admin/recipients') ?>" class="sidebar-link<?= strpos(uri_string(), 'admin/recipients') === 0 ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Beneficiaries</span>
                        </a>
                    </li>
                </ul>
                <div class="nav-label">System</div>
                <ul>
                    <li>
                        <a href="<?= site_url('admin/users') ?>" class="sidebar-link<?= strpos(uri_string(), 'admin/users') === 0 ? ' active' : '' ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Users</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <strong><?= esc(session()->get('admin_username')) ?></strong>
                    <span><?= esc(session()->get('admin_role')) ?></span>
                </div>
                <a href="<?= site_url('admin/logout') ?>" class="sidebar-link logout-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0" id="admin-main-content">
            <!-- Top Bar -->
            <header class="bg-white border-b border-[#e3d6c2] px-6 py-4" style="width: 100%; max-width: 100%;">
                <div class="flex items-center justify-between" style="width: 100%; max-width: 100%;">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl font-bold"><?= isset($pageTitle) ? esc($pageTitle) : 'Dashboard' ?></h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="<?= site_url('/') ?>" target="_blank" class="text-sm text-gray-600 hover:text-[#f2b23a]">
                            View Site →
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6" style="width: 100%; max-width: 100%; min-width: 0; box-sizing: border-box;">
                <?php if (session()->has('success')): ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <?= session()->get('error') ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
