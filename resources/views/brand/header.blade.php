@push('head')
<link href="/favicon.ico" id="favicon" rel="icon">
@endpush

<div class="h2 d-flex align-items-center">
    @auth
    <x-orchid-icon path="bs.house" class="d-inline d-xl-none" />
    @endauth

    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
        <small class="align-bottom opacity h5">Go</small>
    </p>
</div>