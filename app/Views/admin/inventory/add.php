<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl">
    <div class="card bg-white border border-[#e3d6c2] shadow-md">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-6">Add Inventory Item</h3>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/inventory/add') ?>" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Food Type *</span></label>
                    <input type="text" name="food_type" value="<?= old('food_type') ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="e.g., Fresh vegetables, Cooked meals" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Quantity *</span></label>
                        <input type="number" name="quantity" step="0.01" value="<?= old('quantity') ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                    </div>
                    <div>
                        <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Unit</span></label>
                        <select name="unit" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="lbs">lbs</option>
                            <option value="pieces">pieces</option>
                            <option value="meals">meals</option>
                            <option value="boxes">boxes</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Expiration Date</span></label>
                    <input type="date" name="expiration_date" value="<?= old('expiration_date') ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Storage Location</span></label>
                    <input type="text" name="storage_location" value="<?= old('storage_location') ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="e.g., Freezer A, Shelf 3">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Link to Donation (Optional)</span></label>
                    <select name="donation_id" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]">
                        <option value="">None</option>
                        <?php foreach ($donations as $donation): ?>
                            <option value="<?= $donation['id'] ?>"><?= str_pad($donation['id'], 3, '0', STR_PAD_LEFT) ?> - <?= esc($donation['full_name']) ?> - <?= esc($donation['food_type']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Add Item</button>
                    <a href="<?= site_url('admin/inventory') ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
