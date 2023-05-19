<div class="container py-8 mx-auto mt-8 text-center">
    @if ($order)
    <h1 class="my-3 text-3xl font-bold text-teal-600 dark:text-teal-100">Payment Success</h1>
    <img src="{{ asset('images/payment-success.webp') }}" alt="payment success" class="mx-auto h-100" />
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        var duration = 15 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = {
            startVelocity: 30,
            spread: 360,
            ticks: 60,
            zIndex: 0
        };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            // since particles fall down, start a bit higher than random
            confetti(Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.1, 0.3),
                    y: Math.random() - 0.2
                }
            }));
            confetti(Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.7, 0.9),
                    y: Math.random() - 0.2
                }
            }));
        }, 250);
    </script>
    @endpush
    @else
    <h1 class="my-3 text-3xl font-bold text-teal-600 dark:text-teal-100">Something Went Wrong!, <br> Please contact admin or login to your account.</h1>
    @endif


</div>