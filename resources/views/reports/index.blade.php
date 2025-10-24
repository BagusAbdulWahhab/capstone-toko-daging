<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Reports</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Sales Report</h3>
                            <p class="text-gray-600 mb-4">View sales transactions within a date range</p>
                            <a href="{{ route('reports.sales') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Report</a>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Stock Report</h3>
                            <p class="text-gray-600 mb-4">View current stock levels and movements</p>
                            <a href="{{ route('reports.stock') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View Report</a>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Profit Report</h3>
                            <p class="text-gray-600 mb-4">View profit calculations and margins</p>
                            <a href="{{ route('reports.profit') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">View Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>