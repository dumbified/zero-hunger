<div id="donate" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/50 px-6 flex">
    <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between">
            <h3 class="text-3xl font-semibold font-tilt">Food Donation</h3>
            <button type="button" id="closeDonate" class="text-xl">✕</button>
        </div>
        <p class="mt-2 text-base font-times">Please share your donation details and we will contact you.</p>
        <form class="mt-6 grid gap-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Full name</label>
                    <input type="text" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Your name">
                </div>
                <div>
                    <label class="text-sm font-semibold">Phone</label>
                    <input type="tel" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="012-3456789">
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <input type="email" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="you@email.com">
                </div>
                <div>
                    <label class="text-sm font-semibold">Food type</label>
                    <input type="text" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Cooked meals, produce, etc.">
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Estimated quantity</label>
                    <input type="text" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="e.g., 20 meals">
                </div>
                <div>
                    <label class="text-sm font-semibold">Preferred date/time</label>
                    <input type="text" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="e.g., Fri 3pm">
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold">Pickup address</label>
                <input type="text" class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" placeholder="Full address">
            </div>
            <div>
                <label class="text-sm font-semibold">Notes</label>
                <textarea class="mt-1 w-full rounded-lg border border-[#e3d6c2] px-3 py-2" rows="3" placeholder="Any special instructions"></textarea>
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
