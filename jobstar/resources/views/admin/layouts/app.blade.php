@if ($setting->default_layout)
    @include('admin.layouts.left-nav')
@else
    @include('admin.layouts.top-nav')
@endif
<input type="hidden" value="{{ current_country_code() }}" id="current_country_code">
<style>
.card .card-header a.btn.bg-primary.float-right.d-flex.align-items-center.justify-content-center {
    display: none !important;
}
</style>
