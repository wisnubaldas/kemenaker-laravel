<div class="d-flex justify-content-between">
    {{request()->is()}}
    @if($tipe_tender == 0)
        <a href="/usulan-tender" class="btn btn-sm {{request()->is('usulan-tender') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Usulan</a>
        <a href="/usulan-tender-draft/draft" class="btn btn-sm {{request()->is('usulan-tender/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Draft</a>
    @elseif($tipe_tender == 1)
        <a href="/usulan-tender-seleksi" class="btn btn-sm {{request()->is('usulan-tender-seleksi') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Usulan Seleksi</a>
        <a href="/usulan-tender-seleksi/draft" class="btn btn-sm {{request()->is('usulan-tender-seleksi/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Draft Seleksi</a>
    @elseif($tipe_tender == 2)
        <a href="/usulan-tender-pengecualian" class="btn btn-sm {{request()->is('usulan-tender-pengecualian') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Usulan Dikecualikan</a>
        <a href="/usulan-tender-pengecualian/draft" class="btn btn-sm {{request()->is('usulan-tender-pengecualian/draft') ? 'btn-light-primary me-3 fw-bolder' : 'btn-light-secondary'}}">Draft Dikecualikan</a>
    @endif
</div>
