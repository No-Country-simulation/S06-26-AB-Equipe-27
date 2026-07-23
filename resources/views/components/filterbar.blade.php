<style>
    /* ---------------- Toolbar (busca + filtros) ---------------- */
    .toolbar-card {
        background-color: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 1rem 1.15rem;
        box-shadow: var(--shadow-card);
    }

    .search-container {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        border: 1px solid transparent;
        border-radius: var(--radius-sm);
        padding: 0.15rem 0;
    }

    .search-container input {
        border: none;
        outline: none;
        box-shadow: none;
        width: 100%;
        background: transparent;
        color: var(--color-ink);
        font-size: 0.95rem;
    }

    .search-container input::placeholder {
        color: #ACA8C2;
    }

    .filter-divider {
        width: 1px;
        align-self: stretch;
        background-color: var(--color-border);
    }

    .filter-chip {
        border: 1px solid var(--color-border);
        background-color: var(--color-surface);
        color: var(--color-body);
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        white-space: nowrap;
        transition: all .15s ease;
    }

    .filter-chip:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .filter-chip.active {
        background-color: var(--color-ink);
        border-color: var(--color-ink);
        color: #fff;
    }
</style>

<div class="toolbar-card d-flex align-items-center gap-3 mb-4">
    <div class="search-container flex-grow-1">
        <i class="bi bi-search text-muted"></i>
        <input type="text" placeholder="Buscar por título ou área...">
    </div>
    <div class="filter-divider d-none d-sm-block"></div>
    <div class="d-flex gap-2 filter-scroll">
        <button type="button" class="filter-chip active">Todas</button>
        <button type="button" class="filter-chip">Tecnologia</button>
        <button type="button" class="filter-chip">Operações</button>
        <button type="button" class="filter-chip">Comercial</button>
    </div>
</div>