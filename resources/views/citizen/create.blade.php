<x-app-layout title="Tambah Penduduk">
    <div class="dashboard">
        <x-sidebar-component />

        <div class="dashboard-main">
            <x-header title="Tambah Penduduk" subtitle="Isi data berikut untuk mendaftarkan penduduk." />

            <x-panel title="Formulir Data Penduduk">
                <x-citizen-form :action="route('citizens.store')" />
            </x-panel>
        </div>
    </div>
</x-app-layout>
