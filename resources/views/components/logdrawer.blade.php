<!--begin::Trigger button-->

<!--end::Trigger button-->

<!--begin::View component-->
<div
    id="kt_drawer_example_basic"

    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#kt_drawer_example_basic_button"
    data-kt-drawer-close="#kt_drawer_example_basic_close"
    data-kt-drawer-width="500px"
>
<div class="card w-100 rounded-0">
    <!--begin::Card header-->
    <div class="card-header pe-5">
        <!--begin::Title-->
        <div class="card-title">
            <!--begin::User-->
            <div class="d-flex justify-content-center flex-column me-3">
                <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 lh-1">@{{logname}}</a>
            </div>
            <!--end::User-->
        </div>
        <!--end::Title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Close-->
            <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_basic_close">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body hover-scroll-overlay-y">
        <div class="timeline-label">
            <!--begin::Item-->
            <div v-for="log,index in logs" class="timeline-item">
                <!--begin::Label-->
                <div class="timeline-label text-center">
                    <div>@{{objectDate(log.created_date).bln}}</div>
                    <div class="fw-bolder">@{{objectDate(log.created_date).tgl}}</div>
                    <div><small>@{{objectDate(log.created_date).thn}}</small></div>
                </div>
                
                <!--end::Label-->
                <!--begin::Badge-->
                <div class="timeline-badge">
                    <i class="fa fa-genderless text-primary fs-1"></i>
                </div>
                <!--end::Badge-->
                <!--begin::Text-->
                <div class="timeline-content ps-3">
                    <div class=" text-muted">@{{log.user?.nama_lengkap}}</div>
                    <div class="fw-bold ">@{{alurTender[log.alur]}}</div>
                    <div class=" text-muted mb-3">@{{objectDate(log.created_date).jam}}</div>
                    <div v-if="log.keterangan" class="fs-7 btn btn-outline btn-outline-dashed btn-outline-default active d-flex text-start p-2">@{{log.keterangan}}</div>
                </div>
                <!--end::Text-->
            </div>
           
        </div>
    </div>
    <!--end::Card body-->
</div>
</div>
<!--end::View component-->