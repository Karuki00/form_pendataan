@props(['citizen' => null, 'action', 'method' => 'POST'])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
    @method($method)
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
            <h3 class="text-lg font-semibold text-gray-800">Data Pribadi</h3>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="form-group">
                <label for="nik" class="block font-medium text-gray-700">NIK</label>
                <input
                    type="text"
                    name="nik"
                    id="nik"
                    value="{{ old('nik', $citizen?->nik) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nik') border-red-500 @enderror"
                    required>
                @error('nik')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name" class="block font-medium text-gray-700">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $citizen?->name) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
            <h3 class="text-lg font-semibold text-gray-800">Data Keluarga</h3>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="form-group">
                <label for="marital_status" class="block font-medium text-gray-700">Status Pernikahan</label>
                <select
                    name="marital_status"
                    id="marital_status"
                    class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('marital_status') border-red-500 @enderror"
                    required>
                    @php $status = old('marital_status', $citizen?->marital_status); @endphp
                    <option value="">-- Pilih Status --</option>
                    <option value="single" {{ $status === 'single' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="married" {{ $status === 'married' ? 'selected' : '' }}>Menikah</option>
                    <option value="divorced" {{ $status === 'divorced' ? 'selected' : '' }}>Cerai</option>
                    <option value="widowed" {{ $status === 'widowed' ? 'selected' : '' }}>Duda / Janda</option>
                </select>
                @error('marital_status')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="block font-medium text-gray-700">Status Penduduk</label>
                @php $populationStatus = old('status', $citizen?->status ?? 'active'); @endphp
                <select name="status" id="status" class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror" required>
                    <option value="active" {{ $populationStatus === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="moved" {{ $populationStatus === 'moved' ? 'selected' : '' }}>Pindah</option>
                    <option value="deceased" {{ $populationStatus === 'deceased' ? 'selected' : '' }}>Meninggal</option>
                    <option value="inactive" {{ $populationStatus === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div id="wife-field" class="form-group">
                <label for="wife_name" class="block font-medium text-gray-700">Nama Istri / Pasangan</label>
                <input type="text" name="wife_name" id="wife_name" value="{{ old('wife_name', $citizen?->wife_name) }}" class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('wife_name') border-red-500 @enderror">
                @error('wife_name')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="house_status" class="block font-medium text-gray-700">Status Rumah</label>
                <select name="house_status" id="house_status" class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('house_status') border-red-500 @enderror" required>
                    @php $houseStatus = old('house_status', $citizen?->house_status ?? 'owned'); @endphp
                    <option value="">-- Pilih Status Rumah --</option>
                    <option value="owned" {{ $houseStatus === 'owned' ? 'selected' : '' }}>Milik Sendiri</option>
                    <option value="rented" {{ $houseStatus === 'rented' ? 'selected' : '' }}>Sewa</option>
                    <option value="other" {{ $houseStatus === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('house_status')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="house_number" class="block font-medium text-gray-700">Nomor Rumah</label>
                <input type="text" name="house_number" id="house_number" value="{{ old('house_number', $citizen?->house_number) }}" class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('house_number') border-red-500 @enderror" required>
                @error('house_number')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mt-4 max-w-sm">
            <div class="form-group">
                <label for="children_count" class="block font-medium text-gray-700">Jumlah Anak</label>
                <input
                    type="number"
                    name="children_count"
                    id="children_count"
                    value="{{ old('children_count', $citizen?->children_count ?? 0) }}"
                    min="0"
                    class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('children_count') border-red-500 @enderror"
                    required>
                @error('children_count')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
            <h3 class="text-lg font-semibold text-gray-800">Data Ekonomi</h3>
        </div>

        <div class="max-w-md">
            <div class="form-group">
                <label for="income_range" class="block font-medium text-gray-700">Rentang Pendapatan per Bulan</label>
                <select name="income_range" id="income_range" class="mt-1 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('income_range') border-red-500 @enderror" required>
                    @php $incomeRange = old('income_range', $citizen?->income_range ?? '0_3jt'); @endphp
                    <option value="">-- Pilih Rentang Pendapatan --</option>
                    <option value="0_3jt" {{ $incomeRange === '0_3jt' ? 'selected' : '' }}>Rp0–3 juta</option>
                    <option value="4_8jt" {{ $incomeRange === '4_8jt' ? 'selected' : '' }}>Rp4–8 juta</option>
                    <option value="9_15jt" {{ $incomeRange === '9_15jt' ? 'selected' : '' }}>Rp9–15 juta</option>
                    <option value="above_15jt" {{ $incomeRange === 'above_15jt' ? 'selected' : '' }}>Di atas Rp15 juta</option>
                </select>
                @error('income_range')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4">
        <a href="{{ route('citizens.index') }}" class="filter-btn">
            Batal
        </a>
        <button type="submit" class="add-facility-btn">
            {{ $citizen ? 'Perbarui Data' : 'Simpan Data' }}
        </button>
    </div>
</form>

<script>
    (() => {
        const maritalStatus = document.getElementById('marital_status');
        const wifeField = document.getElementById('wife-field');
        const wifeInput = document.getElementById('wife_name');

        if (!maritalStatus || !wifeField || !wifeInput) {
            return;
        }

        const toggleWifeField = () => {
            const isNotMarried = maritalStatus.value === 'single';

            wifeField.hidden = isNotMarried;

            if (isNotMarried) {
                wifeInput.value = '';
            }
        };

        maritalStatus.addEventListener('change', toggleWifeField);
        toggleWifeField();
    })();
</script>