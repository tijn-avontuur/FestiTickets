<x-layouts.app>
    <!-- Hero -->
    <section class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-6">Your Gateway to Unforgettable Events</h1>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">Discover, book, and experience the best festivals and events.</p>
            @guest
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-black text-white px-8 py-4 rounded text-lg hover:bg-gray-800 transition">Get Started</a>
                    <a href="{{ route('login') }}" class="border-2 border-black px-8 py-4 rounded text-lg hover:bg-gray-50 transition">Sign In</a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Features -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Why Choose FestiTickets?</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <h3 class="text-xl font-bold mb-3">Secure Tickets</h3>
                    <p class="text-gray-600 leading-relaxed">QR code verification and encrypted PDFs ensure authentic tickets.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <h3 class="text-xl font-bold mb-3">Easy Payments</h3>
                    <p class="text-gray-600 leading-relaxed">Multiple payment options with instant confirmation.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <h3 class="text-xl font-bold mb-3">Event Discovery</h3>
                    <p class="text-gray-600 leading-relaxed">Browse upcoming festivals with detailed information.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    @guest
        <section class="bg-white py-20">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <p class="text-xl text-gray-600 mb-10">Join thousands of festival-goers.</p>
                <a href="{{ route('register') }}" class="inline-block bg-black text-white px-12 py-4 rounded text-lg hover:bg-gray-800 transition">Create Your Account</a>
            </div>
        </section>
    @endguest
</x-layouts.app>

