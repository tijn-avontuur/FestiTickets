<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Betalingen Beheer</h1>
                <p class="mt-2 text-sm text-gray-600">Overzicht van alle betalingen en orders</p>
            </div>

            <!-- Stats Cards & Chart -->
            @php
                $totalPayments = \App\Models\Payment::count();
                $paidPayments = \App\Models\Payment::where('status', 'paid')->count();
                $pendingPayments = \App\Models\Payment::whereIn('status', ['open', 'pending'])->count();
                $failedPayments = \App\Models\Payment::whereIn('status', ['failed', 'canceled', 'expired'])->count();
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Stats Cards (left side - 2/3) -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Totaal</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $totalPayments }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Betaald</p>
                                    <p class="text-2xl font-semibold text-green-600">{{ $paidPayments }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">In behandeling</p>
                                    <p class="text-2xl font-semibold text-yellow-600">{{ $pendingPayments }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Mislukt</p>
                                    <p class="text-2xl font-semibold text-red-600">{{ $failedPayments }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart (right side - 1/3) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Verdeling</h3>
                    <div class="flex items-center justify-center">
                        <canvas id="paymentStatusChart" class="max-w-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bestelnummer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evenement</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bedrag</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Methode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->order->order_number }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->mollie_payment_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payment->order->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->order->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $payment->order->event->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->order->quantity }} ticket(s)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">€{{ number_format($payment->amount, 2, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->status === 'paid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Betaald
                                            </span>
                                        @elseif(in_array($payment->status, ['open', 'pending']))
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In behandeling
                                            </span>
                                        @elseif(in_array($payment->status, ['failed', 'canceled', 'expired']))
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $payment->method ? ucfirst($payment->method) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payment->created_at->format('d-m-Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Geen betalingen</h3>
                                        <p class="mt-1 text-sm text-gray-500">Er zijn nog geen betalingen gedaan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Terug naar dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('paymentStatusChart');

            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Betaald', 'In behandeling', 'Mislukt'],
                        datasets: [{
                            data: [{{ $paidPayments }}, {{ $pendingPayments }}, {{ $failedPayments }}],
                            backgroundColor: [
                                'rgb(34, 197, 94)',  // green-500
                                'rgb(234, 179, 8)',   // yellow-500
                                'rgb(239, 68, 68)'    // red-500
                            ],
                            borderColor: [
                                'rgb(255, 255, 255)',
                                'rgb(255, 255, 255)',
                                'rgb(255, 255, 255)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12,
                                        family: "'Inter', sans-serif"
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const value = context.parsed;
                                        const total = {{ $totalPayments }};
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        label += value + ' (' + percentage + '%)';
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.app>
