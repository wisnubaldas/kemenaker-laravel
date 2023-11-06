<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            
            <a class="fw-bolder d-flex align-items-center" href="{{ url()->previous() }}">
                <span class="svg-icon svg-icon-3 me-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17.6 4L9.6 12L17.6 20H13.6L6.3 12.7C5.9 12.3 5.9 11.7 6.3 11.3L13.6 4H17.6Z"
                            fill="black" />
                    </svg>
                </span> Kembali</a>
                
            <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ $title ?? '' }}
                <!--begin::Separator-->

                <!--end::Separator-->
                <!--begin::Description-->
                {{-- <small class="text-muted fs-7 fw-bold my-1 ms-1">#XRS-45670</small> --}}
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            @if(isset($btn_save_usulan))
            <button @click="saveDraft" class="btn btn-sm btn-primary">
                <span class="svg-icon  svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z"
                            fill="black" />
                    </svg></span>
                Simpan
            </button>
            @endif
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
