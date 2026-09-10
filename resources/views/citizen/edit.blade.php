<x-app-layout title="Edit Data Penduduk">
    <div class="dashboard">
        <x-sidebar-component />

        <div class="dashboard-main">
            <x-header title="Edit Data Penduduk" subtitle="Perbarui data {{ $citizen->name }}." />

            <x-panel title="Perbarui Data Penduduk">
                <x-citizen-form
                    :citizen="$citizen"
                    :action="route('citizens.update', $citizen)"
                    method="PUT" />
            </x-panel>
        </div>
    </div>
</x-app-layout>
