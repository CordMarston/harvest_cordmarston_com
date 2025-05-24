<x-filament::page>
    <div class="space-y-6">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow">
            <h2 class="text-2xl font-bold">Welcome back!</h2>
            <p class="mt-1 text-sm">Here's what's happening with your company today.</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded-lg shadow border">
                <h3 class="text-sm font-medium text-gray-500">Total Companies</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $totalCompanies }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border">
                <h3 class="text-sm font-medium text-gray-500">Total Projects</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $totalProjects }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border">
                <h3 class="text-sm font-medium text-gray-500">Hours Logged</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ isset($totalHours) ? number_format($totalHours, 1) : 0 }}</p>
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="bg-white rounded-lg shadow border p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Projects</h3>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentProjects as $project)
                    <li class="py-2">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-700">{{ $project->name }}</span>
                            <span class="text-sm text-gray-400">{{ $project->created_at->diffForHumans() }}</span>
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-gray-500 text-sm">No recent projects.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-filament::page>
