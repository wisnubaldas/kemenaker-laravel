<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <div class="card mb-5">
            <div class="card-body pt9 pb-0">

                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <!--begin::Image-->
                    <div>
                        <label class="fw-bolder mb-3">Berkas</label>
                        <div
                            class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">

                            <img class="mw-50px mw-lg-75px" src="/assets/media/svg/files/pdf.svg" alt="image">
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
                                <input class="form-control" value="{{ $data->no_surat_usulan }}" />
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="">
                                <label class="fw-bolder mb-3">Keterangan</label>
                                <textarea class="form-control">
                                    {{ $data->keterangan }}
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
            <button @click="onAdd" class="btn btn-sm btn-primary">
                <i class="bi bi-journal-plus"></i>
                Tambah Tender
            </button>
        </div>
        <hr />
        <div class="card mb-5" v-for="(item,index) in tenderlist" :key="index">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-6">
                        <label class="mb-3 fw-bolder">Jenis Tender</label>
                        <input class="form-control" />
                    </div>
                    <div class="col-6">
                        <label class="mb-3 fw-bolder">Nama Tender</label>
                        <input class="form-control" />
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h3>Berkas Tender</h3>
                    <button @click="onAdd" class="btn btn-sm btn-light-primary">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                        Tambah Berkas
                    </button>
                </div>
                <hr />
                <div class="row" v-for="i in 7">
                    <div class="col-2 mb-3">
                        <div>
                            <div
                                class="card h-100 flex-center bg-light-primary border-primary border border-dashed p-8">
                                <!--begin::Image-->

                                <img src="assets/media/svg/files/upload.svg class=" alt="">
                                <!--end::Image-->
                                <!--begin::Link-->
                                <a href="#" class="text-hover-primary fs-5 fw-bolder mb-2">File Upload</a>
                                <!--end::Description-->
                            </div>
                        </div>

                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-between">
                        <label class="fw-bolder mb-3">Nama Berkas</label>
                        <a href="" class="text-danger fw-bolder">Hapus</a>
                    </div>
                            <input type="text" class="form-control me-4" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" />
                            
                       
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h2>Usulan Anggota Pokja</h2>
                    <button @click="onAdd" class="btn btn-sm btn-primary">
                        <i class="bi bi-people"></i>
                        Tambah Anggota
                    </button>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-3">
                        <label class="fw-bolder mb-3">NIP</label>
                        <input class="form-control"/>
                    </div>
                    <div class="col-3">
                        <label class="fw-bolder mb-3">Nama Lengkap</label>
                        <input class="form-control"/>
                    </div>
                    <div class="col-3">
                        <label class="fw-bolder mb-3">Jabatan</label>
                        <input class="form-control"/>
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-between">
                        <label class="fw-bolder mb-3">No Sertifikat PBJ</label>
                        <a href="" class="text-danger fw-bolder">Hapus</a>
                        </div>
                        <input class="form-control"/>
                    </div>
                </div>
            </div>
        </div>

    </section>
</x-app-layout>
