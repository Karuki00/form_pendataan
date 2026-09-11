@props(['citizen' => null, 'action', 'method' => 'POST'])

<form action="{{ $action }}" method="POST" class="space-y-4">
    @csrf
    @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
    @method($method)
    @endif

    <!-- NIK -->
    <div class="form-group">
        <label for="nik" class="block font-medium text-gray-700">NIK</label>
        <input
            type="text"
            name="nik"
            id="nik"
            value="{{ old('nik', $citizen?->nik) }}"
            class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('nik') border-red-500 @enderror"
            required>
        @error('nik')
        <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Nama Lengkap -->
    <div class="form-group">
        <label for="name" class="block font-medium text-gray-700">Nama Lengkap</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $citizen?->name) }}"
            class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror"
            required>
        @error('name')
        <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Status Pernikahan dan Jumlah Anak -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Marital Status -->
        <div class="form-group">
            <label for="marital_status" class="block font-medium text-gray-700">Status Pernikahan</label>
            <select
                name="marital_status"
                id="marital_status"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('marital_status') border-red-500 @enderror"
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

        <!-- Istri dan Nomor Rumah -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div id="wife-field" class="form-group">
                <label for="wife_name" class="block font-medium text-gray-700">Nama Istri / Pasangan</label>
                <input type="text" name="wife_name" id="wife_name" value="{{ old('wife_name', $citizen?->wife_name) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('wife_name') border-red-500 @enderror">
                @error('wife_name')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="house_number" class="block font-medium text-gray-700">Nomor Rumah</label>
                <input type="text" name="house_number" id="house_number" value="{{ old('house_number', $citizen?->house_number) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('house_number') border-red-500 @enderror" required>
                @error('house_number')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Status Penduduk -->
        <div class="form-group">
            <label for="status" class="block font-medium text-gray-700">Status Penduduk</label>
            @php $status = old('status', $citizen?->status ?? 'active'); @endphp
            <select name="status" id="status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="moved" {{ $status === 'moved' ? 'selected' : '' }}>Pindah</option>
                <option value="deceased" {{ $status === 'deceased' ? 'selected' : '' }}>Meninggal</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
        </div>

        <!-- Children Count -->
        <div class="form-group">
            <label for="children_count" class="block font-medium text-gray-700">Jumlah Anak</label>
            <input
                type="number"
                name="children_count"
                id="children_count"
                value="{{ old('children_count', $citizen?->children_count ?? 0) }}"
                min="0"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('children_count') border-red-500 @enderror"
                required>
            @error('children_count')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Income Range -->
    <div class="form-group">
        <label for="income_range" class="block font-medium text-gray-700">Rentang Pendapatan per Bulan</label>
        <select name="income_range" id="income_range" class="w-full mt-1 border-gray-300 rounded-md shadow-sm @error('income_range') border-red-500 @enderror" required>
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

    <!-- Actions -->
    <div class="form-actions">
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