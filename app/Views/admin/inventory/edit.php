<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl">
    <div class="card bg-white border border-[#e3d6c2] shadow-md">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-6">Edit Inventory Item</h3>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/inventory/edit/' . $item['id']) ?>" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Food Type *</span></label>
                    <input type="text" name="food_type" value="<?= old('food_type', $item['food_type']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Quantity *</span></label>
                        <input type="number" name="quantity" step="0.01" value="<?= old('quantity', $item['quantity']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                    </div>
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Unit</span></label>
                        <select name="unit" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                            <option value="kg" <?= $item['unit'] === 'kg' ? 'selected' : '' ?>>kg</option>
                            <option value="g" <?= $item['unit'] === 'g' ? 'selected' : '' ?>>g</option>
                            <option value="lbs" <?= $item['unit'] === 'lbs' ? 'selected' : '' ?>>lbs</option>
                            <option value="pieces" <?= $item['unit'] === 'pieces' ? 'selected' : '' ?>>pieces</option>
                            <option value="meals" <?= $item['unit'] === 'meals' ? 'selected' : '' ?>>meals</option>
                            <option value="boxes" <?= $item['unit'] === 'boxes' ? 'selected' : '' ?>>boxes</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Expiration Date</span></label>
                    <input type="date" name="expiration_date" value="<?= old('expiration_date', $item['expiration_date']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Storage Location</span></label>
                    <input type="text" name="storage_location" value="<?= old('storage_location', $item['storage_location']) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Status *</span></label>
                    <select name="status" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="available" <?= $item['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                        <option value="reserved" <?= $item['status'] === 'reserved' ? 'selected' : '' ?>>Reserved</option>
                        <option value="distributed" <?= $item['status'] === 'distributed' ? 'selected' : '' ?>>Distributed</option>
                        <option value="expired" <?= $item['status'] === 'expired' ? 'selected' : '' ?>>Expired</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Update Item</button>
                    <a href="<?= site_url('admin/inventory') ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
