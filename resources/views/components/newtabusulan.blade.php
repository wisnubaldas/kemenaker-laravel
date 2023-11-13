<div class="d-flex justify-content-between">
    {{request()->is()}}
    @if($tipe_tender == 0)
        <a href="/usulan-tender" class="btn btn-sm {{request()->is('usulan-tender') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} me-2">Usulan <span class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-primary">5</span></a>
        <a href="/usulan-tender-draft/draft" class="btn btn-sm {{request()->is('usulan-tender/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} position-relative">Draft 
            <span class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-primary">{{ $draft_count }}</span></a>
        </a>
    @elseif($tipe_tender == 1)
        <a href="/usulan-tender-seleksi" class="btn btn-sm {{request()->is('usulan-tender-seleksi') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} me-2">Usulan Seleksi</a>
        <a href="/usulan-tender-seleksi/draft" class="btn btn-sm {{request()->is('usulan-tender-seleksi/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} position-relative">Draft Seleksi 
            <span class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-primary">{{ $draft_count }}</span></a>
    @elseif($tipe_tender == 2)
        <a href="/usulan-tender-dikecualikan" class="btn btn-sm {{request()->is('usulan-tender-dikecualikan') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} me-2">Usulan Dikecualikan</a>
        <a href="/usulan-tender-dikecualikan/draft" class="btn btn-sm {{request()->is('usulan-tender-dikecualikan/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light'}} position-relative">Draft Dikecualikan
            <span class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-primary">{{ $draft_count }}</span></a>
        </a>
    @endif
</div>
