<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <div class="card mb-5">
            <div class="card-body pt9 pb-0">
               
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <!--begin::Image-->
                    <div>
                    <label class="fw-bolder mb-3">Berkas</label>
                    <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                       
                        <img class="mw-50px mw-lg-75px"  src="/assets/media/svg/files/pdf.svg" alt="image">
                    </div>
                    </div>
                    <!--end::Image-->
                    <!--begin::Wrapper-->
                    <div class="flex-grow-1">
                        <!--begin::Head-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="mb-5">
                                <label class="fw-bolder mb-3">No Surat Usulan</label>
                                <input class="form-control" value="{{$data->no_surat_usulan}}"/>
                                </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="">
                                <label class="fw-bolder mb-3">Keterangan</label>
                                <textarea class="form-control">
                                    {{$data->keterangan}}
                                </textarea>
                                </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Head-->
                        <!--begin::Info-->
                        
                        <!--end::Info-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
        <h2>Document Tender</h2>
        <button class="btn btn-primary">
            Tambah Tender
        </button>
        </div>
        <hr/>
        <div class="card">
            <div class="card-body"></div>
        </div>
    </section>
</x-app-layout>