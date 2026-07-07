<style>
    /* ---------------- Page header ---------------- */
    .page-heading .eyebrow {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--color-primary);
    }

    .page-heading h1 {
        font-size: 1.85rem;
        font-weight: 700;
        color: var(--color-ink);
        letter-spacing: -0.02em;
    }

    .page-heading p {
        color: var(--color-muted);
        font-size: 0.95rem;
    }

    .btn-nova-vaga {
        background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: var(--radius-sm);
        padding: 0.65rem 1.35rem;
        border: none;
        box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .btn-nova-vaga:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
    }
</style>

<div class="page-heading d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
    <div>
        <div class="eyebrow mb-2">{{ $eyebrow }}</div>
        <h1 class="mb-1">{{ $page }}</h1>
        <p class="mb-0">{{ $description }}</p>
    </div>

    @if($actionBtn)
    <a href="{{ $actionBtnUrl ?? '#' }}" class="btn btn-nova-vaga d-inline-flex align-items-center gap-2">
        @if($actionBtnIcon)
        <i class="bi {{ $actionBtnIcon }}"></i>
        @endif
        {{ $actionBtn }}
    </a>
    @endif
</div>