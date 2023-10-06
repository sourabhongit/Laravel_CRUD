@props(['type' => 'info'])

<div {{ $attributes->merge(['class' => "alert alert-$type alert-dismissible fade show"]) }} role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.90rem 1rem;">
    </button>
    {{ $slot }}
</div>