<x-app-layout>
    <div class="dashboard">
        <x-sidebar-component />
        <main class="dashboard-main">
            <x-header title="Dashboard Pendataan Penduduk" subtitle="Ringkasan data penduduk dan keluarga." />

        <!-- Header Banner -->
        <div class="dashboard-panel facilities-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h2>Selamat Datang, Admin</h2>
                <p class="card-subtext">Kelola data penduduk dan informasi keluarga.</p>
            </div>
            <div class="banner-actions">
                <div class="export-actions">
                    <a href="{{ route('citizens.export.excel') }}" class="filter-btn">Unduh Excel</a>
                    <a href="{{ route('citizens.export.pdf') }}" class="filter-btn">Unduh PDF</a>
                </div>
                <a href="{{ route('citizens.create') }}" class="add-facility-btn">
                    + Tambah Penduduk
                </a>
            </div>
        </div>

        <!-- Summary Cards Grid -->
        <div class="dashboard-cards">
            @foreach($stats as $stat)
            <div class="dashboard-card">
                <div class="card-top"><span class="card-label">{{ $stat['title'] }}</span><span class="card-icon-badge green">•</span></div>
                <span class="card-value">{{ number_format($stat['value']) }}</span>
                <span class="card-subtext">Current registered records</span>
            </div>
            @endforeach
        </div>

        <!-- Recently Registered Citizens Table -->
        <div class="dashboard-panel">
            <div class="panel-header">
                <h2>Data Penduduk Terbaru</h2>
                <a href="{{ route('citizens.index') }}" class="panel-link">Lihat Semua &rarr;</a>
            </div>

            <div class="admin-table-wrap">
                <table class="schedule-table admin-table">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">NIK</th>
                            <th>Nama Lengkap</th><th>Nama Istri</th><th>No. Rumah</th><th>Status Pernikahan</th><th>Anak</th>
                            <th class="px-6 py-3">Status</th>
                            <th>Pendapatan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentCitizens as $citizen)
                        <tr>
                            <td>{{ $citizen->nik }}</td>
                            <td>{{ $citizen->name }}</td>
                            <td>{{ $citizen->wife_name ?: '-' }}</td>
                            <td>{{ $citizen->house_number }}</td>
                            <td>{{ match($citizen->marital_status) {
                                'single' => 'Belum Menikah',
                                'married' => 'Menikah',
                                'divorced' => 'Cerai',
                                'widowed' => 'Duda / Janda',
                                default => '-',
                            } }}</td>
                            <td>{{ $citizen->children_count }}</td>
                            <td><span class="badge completed">{{ match($citizen->status) {
                                'active' => 'Aktif',
                                'moved' => 'Pindah',
                                'deceased' => 'Meninggal',
                                'inactive' => 'Tidak Aktif',
                                default => '-',
                            } }}</span></td>
                            <td>{{ match($citizen->income_range) {
                                '0_3jt' => 'Rp0 - 3 juta',
                                '4_8jt' => 'Rp4 - 8 juta',
                                '9_15jt' => 'Rp9 - 15 juta',
                                'above_15jt' => 'Di atas Rp15 juta',
                                default => '-',
                            } }}</td>
                            <td>
                                @php
                                $badgeClasses = match($citizen->income_range) {
                                '0_3jt' => 'bg-amber-100 text-amber-800',
                                '4_8jt', '9_15jt' => 'bg-blue-100 text-blue-800',
                                'above_15jt' => 'bg-emerald-100 text-emerald-800',
                                default => 'bg-gray-100 text-gray-800'
                                };
                                @endphp
                                <span class="badge default {{ $badgeClasses }}">
                                    {{ match($citizen->income_range) {
                                        '0_3jt' => 'Rp0 - 3 juta',
                                        '4_8jt' => 'Rp4 - 8 juta',
                                        '9_15jt' => 'Rp9 - 15 juta',
                                        'above_15jt' => 'Di atas Rp15 juta',
                                        default => '-',
                                    } }}
                                </span>
                            </td>
                            <td class="action-links">
                                <a href="{{ route('citizens.edit', $citizen) }}" class="table-link">Ubah</a>
                                <form action="{{ route('citizens.destroy', $citizen) }}" method="POST" onsubmit="return confirm(@js('Hapus data ' . $citizen->name . '?'))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger-link">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                        Belum ada data penduduk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bottom Two-Column Grid -->
        <div class="dashboard-bottom-grid">

            <!-- Financial Categories Breakdown -->
            <div class="dashboard-panel">
                <div class="panel-header"><h2>Ringkasan Pendapatan</h2></div>
                <div class="divide-y divide-gray-100">
                    @foreach($financeSummary as $summary)
                    <div class="py-3 flex justify-between items-center text-sm">
                        <span class="font-medium text-gray-700">{{ $summary['category'] }}</span>
                        <span class="font-semibold text-gray-900 px-3 py-1 bg-gray-50 rounded-md border border-gray-200">
                            {{ number_format($summary['count']) }} penduduk
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- System Info -->
            <div class="dashboard-panel">
                <div>
                    <h2>Informasi Sistem</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Gunakan menu di samping untuk menambah dan memperbarui data penduduk. Pendapatan dikelompokkan berdasarkan rentang yang dipilih.
                    </p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
                    Database: <span class="font-mono text-gray-600">{{ config('database.connections.'.config('database.default').'.database') }}</span>
                </div>
            </div>

        </div>

        </main>
    </div>
</x-app-layout>
