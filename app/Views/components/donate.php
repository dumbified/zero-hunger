<div id="donate" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/50 px-6 flex">
    <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between">
            <h3 class="text-3xl font-semibold ">Food Donation</h3>
            <button type="button" id="closeDonate" class="text-xl">✕</button>
        </div>
        <p class="mt-2 text-base font-times">Please share your donation details and we will contact you.</p>
        <form class="mt-6 grid gap-4" action="<?= site_url('donate') ?>" method="post">
            <?= csrf_field() ?>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Full name</label>
                    <input type="text" name="full_name" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Your name" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Phone</label>
                    <input
                        type="tel"
                        name="phone"
                        class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2"
                        placeholder="012-3456789"
                        pattern="^\d{3}-\d{3,4}\s?\d{4}$"
                        title="Format: 012-345 6789"
                        required
                    >
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <input type="email" name="email" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="you@email.com" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Food type</label>
                    <input type="text" name="food_type" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Cooked meals, produce, etc." required>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Estimated quantity</label>
                    <input type="text" name="estimated_quantity" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="e.g., 20 meals" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Preferred date</label>
                    <input type="date" id="preferredDate" name="preferred_date" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Preferred time</label>
                    <input type="time" id="preferredTime" name="preferred_time" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" required>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold">Pickup address</label>
                <input type="text" name="pickup_address" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Full address" required>
            </div>
            <div>
                <label class="text-sm font-semibold">Notes</label>
                <textarea name="notes" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" rows="3" placeholder="Any special instructions"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="cancelDonate" class="rounded-lg border border-[#e3d6c2] px-4 py-2">Cancel</button>
                <button type="submit" class="btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    const donate = document.querySelector("#donate");
    const openDonateButtons = [
        document.querySelector("#openDonateNav"),
        document.querySelector("#openDonateHero"),
    ];
    const closeDonateButtons = [
        document.querySelector("#closeDonate"),
        document.querySelector("#cancelDonate"),
    ];

    const openDonate = () => donate.classList.remove("hidden");
    const closeDonate = () => donate.classList.add("hidden");

    openDonateButtons.forEach((btn) => btn && btn.addEventListener("click", openDonate));
    closeDonateButtons.forEach((btn) => btn && btn.addEventListener("click", closeDonate));

    donate.addEventListener("click", (event) => {
        if (event.target === donate) closeDonate();
    });

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
