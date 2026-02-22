<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page not found - Zero Hunger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap">
    <link rel="stylesheet" href="/global.css">
    <style>
        .font-playfair { font-family: "Playfair Display", serif; }
        .err-hero { min-height: 60vh; }
    </style>
</head>

    <main class="mx-auto max-w-2xl px-4 py-16 sm:py-24 text-center err-hero flex flex-col items-center justify-center">
        <p class="text-6xl sm:text-8xl font-bold font-playfair text-[#f2b23a]">404</p>
        <h1 class="mt-4 text-2xl font-bold text-[#1b1b1b] sm:text-3xl">Page not found</h1>
        <p class="mt-3 text-[#4a3b2a]">
            <?php if (ENVIRONMENT !== 'production' && ! empty($message)) : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                Oops! We couldn't find that page.
            <?php endif; ?>
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="/" class="inline-flex items-center justify-center rounded-lg bg-[#f2b23a] px-6 py-3 font-semibold text-[#1b1b1b] hover:opacity-90">
                Back to Home
            </a>
        </div>
    </main>
</body>
</html>
