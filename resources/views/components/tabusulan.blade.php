{{-- <div class="d-flex">
    <button type="button" class="btn btn-sm" @click="tabusulan_active=1" :class="tabusulan_active==1?' btn-light-primary me-3 fw-bolder':'btn-light-secondary'">Usulan</button>
    <button type="button" class="btn btn-sm" @click="tabusulan_active=2" :class="tabusulan_active==2?' btn-light-primary me-3 fw-bolder':'btn-light-secondary'" >Draft</button>
</div> --}}
<div class="d-flex justify-content-between">
    <a href="/usulan-tender" class="btn btn-sm {{request()->is('usulan-tender')?' btn-light-primary me-3 fw-bolder':'btn-light-secondary'}} ">Usulan</a>
    <a href="/usulan-tender/draft" class="btn btn-sm {{request()->is('usulan-tender/draft')?' btn-light-primary me-3 fw-bolder':'btn-light-secondary'}}" >Draft</a>
</div> 