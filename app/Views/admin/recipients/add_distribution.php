<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-3xl">
    <div class="card bg-white border border-[#e3d6c2] shadow-md">
        <div class="card-body p-6">
            <h3 class="text-xl font-bold text-[#4a3b2a] mb-6">Record Distribution for <?= esc($recipient['name']) ?></h3>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/recipients/add-distribution') ?>" class="space-y-6" id="distributionForm">
                <?= csrf_field() ?>
                <input type="hidden" name="recipient_id" value="<?= $recipient['id'] ?>">
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Distribution Date *</span></label>
                    <input type="date" name="date" value="<?= old('date', date('Y-m-d')) ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Items *</span></label>
                    <div id="itemsContainer" class="space-y-3">
                        <div class="item-row border border-[#e3d6c2] rounded-lg p-4 bg-[#fffaf2]">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Food Type</span></label>
                                    <input type="text" name="item_food_type[]" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
                                </div>
                                <div>
                                    <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Quantity</span></label>
                                    <input type="number" step="0.01" name="item_quantity[]" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
                                </div>
                                <div>
                                    <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Unit</span></label>
                                    <input type="text" name="item_unit[]" value="kg" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addItem" class="mt-2 text-sm text-[#f2b23a] hover:underline">+ Add Another Item</button>
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Delivery Method</span></label>
                    <input type="text" name="delivery_method" value="<?= old('delivery_method') ?>" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="e.g., Pickup, Delivery, etc.">
                </div>
                <div>
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Notes</span></label>
                    <textarea name="notes" rows="3" class="textarea textarea-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]"><?= old('notes') ?></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn border-[#f2b23a] bg-[#f2b23a] text-black hover:bg-[#e8a72f]">Record Distribution</button>
                    <a href="<?= site_url('admin/recipients/view/' . $recipient['id']) ?>" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'item-row border border-[#e3d6c2] rounded-lg p-4 bg-[#fffaf2]';
    newRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Food Type</span></label>
                <input type="text" name="item_food_type[]" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
            </div>
            <div>
                <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Quantity</span></label>
                <input type="number" step="0.01" name="item_quantity[]" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
            </div>
            <div>
                <label class="label p-0 mb-1"><span class="label-text text-xs font-semibold">Unit</span></label>
                <input type="text" name="item_unit[]" value="kg" class="input input-bordered input-sm w-full bg-white border-[#e3d6c2]" required>
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-item text-red-600 hover:underline text-sm">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    newRow.querySelector('.remove-item').addEventListener('click', function() {
        newRow.remove();
    });
});

document.getElementById('distributionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const items = [];
    const foodTypes = formData.getAll('item_food_type[]');
    const quantities = formData.getAll('item_quantity[]');
    const units = formData.getAll('item_unit[]');
    for (let i = 0; i < foodTypes.length; i++) {
        items.push({
            food_type: foodTypes[i],
            quantity: parseFloat(quantities[i]),
            unit: units[i]
        });
    }
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'items';
    hiddenInput.value = JSON.stringify(items);
    this.appendChild(hiddenInput);
    this.submit();
});
</script>

<?= $this->endSection() ?>
