<!-- DaisyUI Modal: Request Help panel -->
<input id="needHelpModal" type="checkbox" class="modal-toggle" />
<div id="needHelp" class="modal" role="dialog" aria-modal="true">
    <div class="modal-box w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-3xl font-semibold">Request Help</h3>
                <p class="mt-2 text-base font-times">If you’re an organization or an individual in need, fill in the form and we’ll reach out.</p>
            </div>
            <button type="button" id="closeNeedHelp" class="btn btn-sm btn-circle btn-ghost text-xl">✕</button>
        </div>

        <form class="mt-6 grid gap-4" action="<?= site_url('request-help') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">I am a(n)</span></label>
                    <select name="type" class="select select-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                        <option value="individual" selected>Individual</option>
                        <option value="organization">Organization</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Name</span></label>
                    <input type="text" name="name" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Your name / organization name" required>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Phone</span></label>
                    <input
                        type="tel"
                        name="phone"
                        class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]"
                        placeholder="012-3456789"
                        pattern="^\d{3}-\d{3,4}\s?\d{4}$"
                        title="Format: 012-345 6789"
                        required
                    >
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Email</span></label>
                    <input type="email" name="email" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="you@email.com" required>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Service area</span></label>
                    <input type="text" name="service_area" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="e.g., Kuala Lumpur" required>
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Address</span></label>
                    <input type="text" name="address" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Full address" required>
                </div>
            </div>

            <div class="form-control">
                <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Notes</span></label>
                <textarea name="notes" class="textarea textarea-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" rows="3" placeholder="Tell us what support you need (optional)"></textarea>
            </div>

            <div class="modal-action flex items-center justify-end gap-3">
                <button type="button" id="cancelNeedHelp" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</button>
                <button type="submit" class="btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <label class="modal-backdrop" for="needHelpModal">Close</label>
</div>

<script>
    const needHelpToggle = document.querySelector("#needHelpModal");
    const openNeedHelpButtons = [
        document.querySelector("#openNeedHelpNav"),
    ];
    const closeNeedHelpButtons = [
        document.querySelector("#closeNeedHelp"),
        document.querySelector("#cancelNeedHelp"),
    ];

    const openNeedHelp = () => { if (needHelpToggle) needHelpToggle.checked = true; };
    const closeNeedHelp = () => { if (needHelpToggle) needHelpToggle.checked = false; };

    openNeedHelpButtons.forEach((btn) => btn && btn.addEventListener("click", openNeedHelp));
    closeNeedHelpButtons.forEach((btn) => btn && btn.addEventListener("click", closeNeedHelp));

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") closeNeedHelp();
    });
</script>

