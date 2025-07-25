<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Date Range Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="pt-5">
                            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700">Filter</button>
                            <a href="{{ route('admin.reports.index') }}" class="ml-2 text-gray-600 hover:text-gray-800">Reset</a>
                            <a href="{{ route('admin.reports.downloadPdf', ['start_date' => request('start_date', $startDate->format('Y-m-d')), 'end_date' => request('end_date', $endDate->format('Y-m-d'))]) }}" class="ml-2 bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">Download PDF</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">RM{{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Avg. Order Value</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">RM{{ number_format($avgOrderValue, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">New Customers</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($newCustomers) }}</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Sales Over Time</h3>
                    <canvas id="salesOverTimeChart"></canvas>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Order Status Breakdown</h3>
                    <canvas id="orderStatusChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Data Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Buang section Top Selling Products dan Top Spending Customers -->
            </div>

        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sales Over Time Chart
            const salesCtx = document.getElementById('salesOverTimeChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($salesChartData['labels']),
                    datasets: [{
                        label: 'Total Sales (RM)',
                        data: @json($salesChartData['data']),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Order Status Breakdown Chart
            const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: @json($orderStatusChartData['labels']),
                    datasets: [{
                        label: 'Order Status',
                        data: @json($orderStatusChartData['data']),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(199, 199, 199, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>