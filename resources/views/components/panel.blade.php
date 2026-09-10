@props(['title' => null])

<section class="dashboard-panel">
    @if($title)
        <div class="panel-header">
            <h2>{{ $title }}</h2>
        </div>
    @endif
    {{ $slot }}
</section>
