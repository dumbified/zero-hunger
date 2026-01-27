<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Zero Hunger</title>
        <meta name="description" content="The small framework with powerful features">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="/favicon.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap">

        <!-- STYLES -->
        <link rel="stylesheet" href="/global.css">
        
    </head>
    <body class="h-[100svh] overflow-y-scroll scroll-smooth snap-y snap-mandatory">
        <header class="fixed top-0 left-0 z-30 w-full bg-[#efe0c9]">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    
                <a href="/" class="flex items-center gap-4">
                    <img src="logo.png" alt="zhlogo" class="h-20 w-20 object-contain">
                    <span class="text-3xl font-semibold">Zero Hunger</span>
                </a>
                </div>
                <nav class="flex items-center gap-8 text-lg">
                    <a href="#about" class="nav-link">About us</a>
                    <button class="btn-primary" id="openDonateNav">Donate</button>
                </nav>
            </div>
        </header>

        <main class="min-h-screen">
            <section class="relative mx-auto flex min-h-[100svh] w-full max-w-6xl items-center gap-10 overflow-hidden px-6 pb-16 pt-24 snap-start">
                <div class="relative z-10 w-3/5">
                    <h1 class="text-8xl font-bold font-tilt">
                        Waste Less.<br>
                        Feed More.
                    </h1>
                    <p class="mt-6 max-w-xl text-xl font-times leading-relaxed">
                        In Malaysia, <span class="font-semibold">44%</span> of all daily waste is food.
                        That's <span class="font-semibold">17,000</span> tonnes thrown away every single day.
                    </p>
                    <button class="btn-2nd mt-6 text-xl" id="openDonateHero">Make change now</button>
                </div>
                <div class="w-2/5">
                    <img src="hero_img.png" alt="hero image" class="-ml-52 -mt-10 h-auto w-full max-w-[900px] scale-[1.7] origin-left object-contain opacity-90">
                </div>
            </section>
            <hr class="mx-auto w-full max-w-6xl border-t">
            <section id="about" class="relative mx-auto flex min-h-[100svh] w-full max-w-6xl flex-col items-center justify-center scroll-mt-24 px-6 py-10 snap-start">
                <img src="logo.png" alt="" class="pointer-events-none absolute left-1/2 top-1/2 w-[720px] -translate-x-1/2 -translate-y-1/2 opacity-10">
                <div class="relative z-10 max-w-4xl text-left">
                    <h2 class="text-7xl font-bold font-tilt">About us</h2>
                    <p class="mt-4 text-xl font-times leading-relaxed">
                        We're just a group of ordinary people who think it's crazy that good food goes to
                        the trash while people go hungry. So, we decided to do something about it. We
                        rescue fresh food and get it to the neighbors who need it most. Simple as that.
                    </p>
                    <p class="mt-6 text-xl font-times font-semibold">We have achieved:</p>
                </div>
                <div class="relative z-10 mt-8 grid w-full max-w-4xl gap-8 text-center sm:grid-cols-3">
                    <div>
                        <div class="text-4xl font-black text-[#f2b23a] counter" data-target="98">0%</div>
                        <div class="mt-1 text-xl font-times">of<br><span class="font-semibold">Diverted from</span><br><span class="font-semibold">Landfills</span></div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-[#f06b5e] counter" data-target="67">0%</div>
                        <div class="mt-1 text-xl font-times">of<br><span class="font-semibold">Fresh Produce</span><br><span class="font-semibold">rescued</span></div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-[#6cc1f5] counter" data-target="100">0%</div>
                        <div class="mt-1 text-xl font-times">of<br><span class="font-semibold">Volunteer Powered</span></div>
                    </div>
                </div>
            </section>
            <footer class="mt-6 w-full bg-[#efe0c9]">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6">    
                    <div>
                        <a href="https://sdgs.un.org/goals/goal2" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-3">
                            <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-02.jpg" alt="SDG 2 Zero Hunger icon" class="h-12 w-12 rounded-md object-cover">
                            <div>
                                <div class="text-lg font-semibold">SDG 2</div>
                            </div>
                        </a>
                    </div>
                    <div>
                        <p class="mt-4 font-times text-lg font-semibold">All rights reserved © 2026 Zero Hunger</p>
                    </div>
                    <div>
                        <p class="mt-4 font-times text-lg"><span class="font-semibold">Contact:</span><a href="mailto:hello@zerohunger.org" class="contact-link"> hello@zerohunger.org</a></p>
                    </div>
                </div>
            </footer>
        </main>

        <?= view('components/donate') ?>

    <!-- -->

        <script>
            const counters = document.querySelectorAll(".counter");
            const about = document.querySelector("#about");

            const animateCounters = () => {
                counters.forEach((el) => {
                    const target = parseInt(el.dataset.target, 10);
                    let current = 0;
                    const step = Math.max(1, Math.ceil(target / 60));
                    const tick = () => {
                        current = Math.min(target, current + step);
                        el.textContent = current + "%";
                        if (current < target) requestAnimationFrame(tick);
                    };
                    tick();
                });
            };

            const observer = new IntersectionObserver((entries, obs) => {
                if (entries[0].isIntersecting) {
                    animateCounters();
                    obs.disconnect();
                }
            }, { threshold: 0.5 });

            observer.observe(about);
        </script>
    </body>
</html>
