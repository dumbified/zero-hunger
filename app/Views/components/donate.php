<!-- DaisyUI Modal: Donate panel -->
<input id="donateModal" type="checkbox" class="modal-toggle" />
<div id="donate" class="modal" role="dialog" aria-modal="true">
    <div class="modal-box w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-3xl font-semibold">Food Donation</h3>
                <p class="mt-2 text-base font-times">Please share your donation details and we will contact you.</p>
            </div>
            <button type="button" id="closeDonate" class="btn btn-sm btn-circle btn-ghost text-xl">✕</button>
        </div>

        <form class="mt-6 grid gap-4" action="<?= site_url('donate') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Full name</span></label>
                    <input type="text" name="full_name" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Your name" required>
                </div>
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
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Email</span></label>
                    <input type="email" name="email" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="you@email.com" required>
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Food type</span></label>
                    <input type="text" name="food_type" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Cooked meals, produce, etc." required>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Estimated quantity</span></label>
                    <input type="text" name="estimated_quantity" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="e.g., 20 meals" required>
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Preferred date</span></label>
                    <input type="date" id="preferredDate" name="preferred_date" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
                <div class="form-control">
                    <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Preferred time</span></label>
                    <input type="time" id="preferredTime" name="preferred_time" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" required>
                </div>
            </div>

            <div class="form-control">
                <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Pickup address</span></label>
                <input type="text" name="pickup_address" class="input input-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" placeholder="Full address" required>
            </div>

            <div class="form-control">
                <label class="label p-0 mb-2"><span class="label-text text-sm font-semibold">Notes</span></label>
                <textarea name="notes" class="textarea textarea-bordered w-full bg-[#fffaf2] border-[#e3d6c2] focus:outline-none focus:border-[#f2b23a] focus:ring-1 focus:ring-[#f2b23a]" rows="3" placeholder="Any special instructions"></textarea>
            </div>

            <div class="modal-action flex items-center justify-end gap-3">
                <button type="button" id="cancelDonate" class="btn btn-outline border-[#e3d6c2] bg-[#fffaf2] text-[#4a3b2a] hover:bg-[#efe0c9]">Cancel</button>
                <button type="submit" class="btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <label class="modal-backdrop" for="donateModal">Close</label>
</div>

<script>
    const donateToggle = document.querySelector("#donateModal");
    const openDonateButtons = [
        document.querySelector("#openDonateNav"),
        document.querySelector("#openDonateHero"),
    ];
    const closeDonateButtons = [
        document.querySelector("#closeDonate"),
        document.querySelector("#cancelDonate"),
    ];

    const openDonate = () => { if (donateToggle) donateToggle.checked = true; };
    const closeDonate = () => { if (donateToggle) donateToggle.checked = false; };

    openDonateButtons.forEach((btn) => btn && btn.addEventListener("click", openDonate));
    closeDonateButtons.forEach((btn) => btn && btn.addEventListener("click", closeDonate));

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") closeDonate();
    });
</script>

<script>
    const preferredDate = document.querySelector("#preferredDate");
    const preferredTime = document.querySelector("#preferredTime");

    const setDefaultPreferredDateTime = () => {
        if (!preferredDate || !preferredTime) return;
        const now = new Date();
        const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
        const dateValue = tomorrow.toISOString().slice(0, 10);
        const timeValue = tomorrow.toTimeString().slice(0, 5);
        if (!preferredDate.value) preferredDate.value = dateValue;
        if (!preferredTime.value) preferredTime.value = timeValue;
    };

    setDefaultPreferredDateTime();
</script>
