@php
use App\Models\Admin\Setting;
$paginationMethod = Setting::get('pagination_method');
@endphp

@if($paginationMethod && $paginationMethod == 'scroll')
<div class="ajaxPaginationEnabled loader text-center d-none" data-url="{{ $pagination->path() }}" data-page="1" data-counter="{{ $pagination->perPage() }}" data-total="{{ $pagination->total() }}">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@else
<div class="card-footer py-4">
	{{ $pagination->appends($_GET)->links() }}
</div>
@endif