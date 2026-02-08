<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Today's Pickups -->
<?php if (!empty($todayPickups)): ?>
    <div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-4">Today's Pickups</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($todayPickups as $pickup): ?>
                    <div class="border border-[#e3d6c2] rounded-lg p-4 bg-[#fffaf2] hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h4 class="font-semibold"><?= esc($pickup['full_name']) ?></h4>
                                <p class="text-sm text-gray-600"><?= esc($pickup['food_type']) ?></p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">Scheduled</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-2">
                            <div>📅 <?= date('H:i', strtotime($pickup['scheduled_time'])) ?></div>
                            <div>📍 <?= esc($pickup['pickup_address']) ?></div>
                            <div>📞 <?= esc($pickup['phone']) ?></div>
                        </div>
                        <a href="<?= site_url('admin/donations/view/' . $pickup['id']) ?>" class="text-sm text-[#f2b23a] hover:underline">View Details →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Calendar View -->
<div class="card bg-white border border-[#e3d6c2] shadow-md mb-6">
    <div class="card-body p-6">
        <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
            <h3 class="text-xl font-bold text-[#4a3b2a]">Pickup Calendar</h3>
            <div class="flex items-center gap-2">
                <a href="<?= site_url('admin/pickups?view=month&date=' . date('Y-m-d', strtotime('-1 month', strtotime($date)))) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9] btn-sm">← Previous</a>
                <span class="px-4 py-2 font-semibold text-[#4a3b2a]"><?= date('F Y', strtotime($date)) ?></span>
                <a href="<?= site_url('admin/pickups?view=month&date=' . date('Y-m-d', strtotime('+1 month', strtotime($date)))) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9] btn-sm">Next →</a>
            </div>
        </div>

        <!-- Legend: yellow = today -->
        <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 rounded bg-[#f2b23a]/30 border border-[#e3d6c2]"></span>
                Today
            </span>
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-1.5 bg-purple-500 rounded block"></span>
                Day has scheduled pickup(s)
            </span>
        </div>

        <div class="grid grid-cols-7 gap-2">
            <?php
            $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($daysOfWeek as $day): ?>
                <div class="text-center font-semibold text-gray-600 py-2 text-sm uppercase"><?= $day ?></div>
            <?php endforeach; ?>

            <?php
            $firstDay = date('Y-m-01', strtotime($date));
            $lastDay = date('Y-m-t', strtotime($date));
            $startDay = date('w', strtotime($firstDay));
            $daysInMonth = date('t', strtotime($date));

            for ($i = 0; $i < $startDay; $i++): ?>
                <div class="aspect-square border border-[#e3d6c2] rounded-lg bg-gray-50/50"></div>
            <?php endfor; ?>

            <?php
            for ($day = 1; $day <= $daysInMonth; $day++):
                $currentDate = date('Y-m-d', strtotime($firstDay . ' +' . ($day - 1) . ' days'));
                $dayPickups = array_filter($scheduledPickups, function($p) use ($currentDate) {
                    return $p['scheduled_time'] && date('Y-m-d', strtotime($p['scheduled_time'])) === $currentDate;
                });
                $isToday = $currentDate === date('Y-m-d');
            ?>
                <div class="aspect-square border border-[#e3d6c2] rounded-lg p-1.5 flex flex-col <?= $isToday ? 'bg-[#f2b23a]/30 ring-1 ring-[#f2b23a]' : 'bg-[#fffaf2]' ?>">
                    <div class="text-sm font-semibold text-[#4a3b2a]"><?= $day ?></div>
                    <?php if (!empty($dayPickups)): ?>
                        <div class="mt-auto text-xs">
                            <div class="w-full h-1 bg-purple-500 rounded mb-0.5"></div>
                            <div class="text-gray-600"><?= count($dayPickups) ?> pickup<?= count($dayPickups) > 1 ? 's' : '' ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- Scheduled Pickups List -->
<div class="bg-white rounded-lg shadow-md border border-[#e3d6c2]">
    <div class="p-6 border-b border-[#e3d6c2]">
        <h3 class="text-xl font-bold text-[#4a3b2a]">All Scheduled Pickups</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#efe0c9]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Date/Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Donor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Food Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e3d6c2] text-sm">
                <?php if (empty($scheduledPickups)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No scheduled pickups</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($scheduledPickups as $pickup): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><?= $pickup['scheduled_time'] ? date('M d, Y H:i', strtotime($pickup['scheduled_time'])) : '-' ?></td>
                            <td class="px-6 py-4"><?= esc($pickup['full_name']) ?></td>
                            <td class="px-6 py-4"><?= esc($pickup['food_type']) ?></td>
                            <td class="px-6 py-4 text-sm"><?= esc($pickup['pickup_address']) ?></td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $pickup['status'] ?? 'pending';
                                $statusText = $status ? ucfirst(str_replace('_', ' ', $status)) : 'Unknown';
                                $statusClass = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'scheduled' => 'bg-purple-100 text-purple-800',
                                    'picked_up' => 'bg-green-100 text-green-800',
                                ];
                                $class = $statusClass[$status] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold <?= $class ?>"><?= esc($statusText) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?= site_url('admin/donations/view/' . $pickup['id']) ?>" class="text-[#f2b23a] hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
