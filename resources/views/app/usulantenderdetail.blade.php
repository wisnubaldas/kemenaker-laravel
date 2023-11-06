<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <script>
            var tenderData = @json($data);
        </script>
        @include('components.modalpdf')
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-6 mb-xl-9">
            {{ $data->alur }}
            <div class="card-body pt-9 pb-0">
                <div class="row">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-3">
                                <div
                                    class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                    <img class="scale-hover mw-50px mw-lg-75px" data-bs-target="#kt_modal_new_card"
                                        @click="pathmodalactive='storage/surat_usulan/'+tenderData.file_surat_usulan"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                        style="cursor: pointer" src="/assets/media/svg/files/pdf.svg" alt="image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <!--begin::Details-->
                                    <div class="d-flex flex-column w-100">
                                        <!--begin::Status-->
                                        <span
                                            class="badge  {{ config('params.badgecolor.' . $data->alur) }} me-auto mb-3">{{ config('params.alur.' . $data->alur) }}</span>
                                        <div class="d-flex align-items-center mb-1">
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3">{{ $data->usulanTender->no_surat_usulan }}</a>

                                        </div>
                                        <!--end::Status-->
                                        <!--begin::Description-->
                                        <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">Keterangan:
                                            {{ $data->usulanTender->keterangan ?? '-' }}</div>
                                        <div class="separator mb-2"></div>
                                        <div class="d-flex flex-wrap ">
                                            <div
                                                class="border border-gray-300 border-dashed rounded w-100 py-3 px-4 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="svg-icon svg-icon-muted svg-icon-2hx me-3"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3"
                                                                d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                                fill="black" />
                                                            <path
                                                                d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                                fill="black" />
                                                        </svg></span>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-4 fw-bolder me-3">{{ $data->nama_tender }}</a>
                                                </div>
                                                <a href="#"
                                                    class="text-gray-600 text-hover-primary fs-6 fw-bolder me-3">#{{ $data->tmJenisTender->jenis_tender }}</a>
                                            </div>
                                        </div>

                                        <!--end::Description-->
                                    </div>
                                    <!--end::Details-->
                                    <!--begin::Actions-->



                                    <!--end::Actions-->
                                </div>

                            </div>
                        </div>
                        <div class="fs-3 fw-bold mb-5">Daftar Pokja</div>
                        <div class="separator mb-4"></div>
                        @if (count($data->usulanTenderPokja) < 1)
                            <img src="/images/notFound.png" class="img h-70px" />
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                            <td>Nip & Nama</td>
                                            <td>Jabatan</td>
                                            <td>Unit Kerja</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->usulanTenderPokja as $pokja)
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <!--begin:: Avatar -->
                                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                        <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                            <div
                                                                class="symbol-label fs-3 bg-light-primary text-primary">
                                                                {{ ($pokja->nama_lengkap ?? '-')[0] }}</div>
                                                        </a>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::User details-->
                                                    <div class="d-flex flex-column">
                                                        <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                            class="text-gray-800 fw-bolder mb-1">{{ $pokja->nama_lengkap ?? '-' }}</a>
                                                        <span>{{ $pokja->nip ?? '-' }}</span>
                                                    </div>
                                                    <!--begin::User details-->
                                                </td>
                                                <td>
                                                    {{ $pokja->jabatan ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $pokja->unit_kerja ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="col-5">

                        @if ($data->alur == 13 && auth()->user()->tagroup_id == 2)
                            <div class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                <div class="fs-4 fw-bolder mb-5">Verifikasi Berita Acara Hasil Pemilihan</div>
                                <div class="separator"></div>
                                <form
                                    action="/usulan-tender/sph/{{ Route::current()->parameter('tender_detail_id') }}"
                                    method="POST" enctype="multipart/form-data" class="p-3">
                                    @csrf
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" @change="changeOpt($event)" @if(old('approve')) checked @endif  name="approve"  type="checkbox"
                                            ref="flexSwitchChecked2" id="flexSwitchChecked2" />
                                        <label class="form-check-label fw-bolder" :class="checked?'text-success':'text-danger'" for="flexSwitchChecked2">
                                            @{{checked?'Terima':'Tolak'}}
                                        </label>
                                    </div>
                                    <div v-if="checked">
                                        <input hidden ref="file_lap_hpk"
                                            @change="updateFileName($event,'file_lap_hpk_name')" type="file"
                                            name="file_lap_hpk" />
                                        <div v-if="file_lap_hpk_name"
                                            class="image-input d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                            <label @click="openFilePicker('file_lap_hpk')"
                                                class="btn btn-icon btn-circle  w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="" data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--end::Inputs-->
                                            </label>

                                            <img class=" mw-50px mw-lg-75px"
                                                style="cursor: pointer"
                                                src="/assets/media/svg/files/pdf.svg" alt="image">
                                            <span class="w-75 mt-3 text-center text-2-row text-wrap"
                                                v-html="file_lap_hpk_name"></span>
                                        </div>
                                        <div v-else @click="openFilePicker('file_lap_hpk')" style="cursor: pointer"
                                            class="card h-75 flex-center {{ $errors->has('file_lap_hpk') ? 'bg-light-danger border-danger' : 'bg-light-primary border-primary' }} border border-dashed p-8 mb-4">

                                            <img src="/assets/media/svg/files/upload.svg" class="h-20px"
                                                alt="">
                                            <a href="#" class=" fs-6 fw-bolder mb-2">Laporan Hasil
                                                Penandatanganan Kontrak</a>
                                            @error('file_lap_hpk')
                                                <div class="text-center invalid-feedback d-block mb-3">{{ $message }}
                                                </div>
                                            @enderror


                                        </div>
                                        <input hidden ref="file_spk"
                                            @change="updateFileName($event,'file_spk_name')" type="file"
                                            name="file_spk" />
                                        <div v-if="file_spk_name"
                                            class="image-input d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                            <label @click="openFilePicker('file_spk')"
                                                class="btn btn-icon btn-circle  w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="" data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--end::Inputs-->
                                            </label>

                                            <img class="mw-50px mw-lg-75px"
                                                style="cursor: pointer"
                                                src="/assets/media/svg/files/pdf.svg" alt="image">
                                            <span class="w-75 mt-3 text-center text-2-row text-wrap"
                                                v-html="file_spk_name"></span>
                                        </div>
                                        <div v-else @click="openFilePicker('file_spk')" style="cursor: pointer"
                                            class="card h-75 flex-center {{ $errors->has('file_spk') ? 'bg-light-danger border-danger' : 'bg-light-primary border-primary' }} border border-dashed p-8 mb-4">

                                            <img src="/assets/media/svg/files/upload.svg" class="h-20px"
                                                alt="">
                                            <a href="#" class=" fs-6 fw-bolder mb-2">Surat Perjanjian
                                                Kontrak</a>
                                            @error('file_spk')
                                                <div class="text-center invalid-feedback d-block mb-3">{{ $message }}
                                                </div>
                                            @enderror


                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-light-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if (($data->alur == 0 && auth()->user()->tagroup_id == 3) 
                        || ($data->alur == 7 && auth()->user()->tagroup_id == 3)
                        || ($data->alur == 16 && auth()->user()->tagroup_id == 3))
                            <form class="form-control mb-3">
                                <label class="fs-3 mb-3">{{ config('params.form-title.' . $data->alur) }}</label>
                                <div class="separator mb-3"></div>

                                <label class="mb-3">Keterangan</label>
                                <textarea v-model="catatan" class="form-control mb-3"></textarea>
                                <div class="d-flex justify-content-end">
                                    <button
                                        @click="rejectUsulan({{ Route::current()->parameter('tender_detail_id') }})"
                                        type="button" class="btn btn-sm btn-light-danger me-3">Tolak</button>
                                    <button
                                        @click="approveUsulan({{ Route::current()->parameter('tender_detail_id') }})"
                                        type="button" class="btn btn-sm btn-light-primary">Terima</button>
                                </div>
                            </form>
                        @endif
                        <div class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                            <div class="fs-4 fw-bolder mb-5">Informasi LPSE</div>
                            <div class="separator"></div>
                            @if ($data->alur == 9 && auth()->user()->tagroup_id == 2)
                                <form
                                    action="/usulan-tender/lpse/{{ Route::current()->parameter('tender_detail_id') }}"
                                    method="POST" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <label class="mb-2 fw-bold">Kode Tender</label>
                                    <input
                                        class="form-control {{ $errors->has('kode_tender') ? 'is-invalid' : 'mb-3' }} "
                                        name="kode_tender" />
                                    @error('kode_tender')
                                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                    @enderror
                                    <label class="mb-2 fw-bold">Kode Rup</label>
                                    <input
                                        class="form-control {{ $errors->has('kode_rup') ? 'is-invalid' : 'mb-3' }} "
                                        name="kode_rup" />
                                    @error('kode_rup')
                                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                    @enderror
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-light-primary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            @else
                                @if ($data->kode_rup && $data->kode_tender)
                                    <div class="row">
                                        <div class="col-6 p-2">
                                            <div
                                                class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                                <div class="fs-7 text-muted fw-bolder ">Kode Tender</div>
                                                <div class="fs-5 fw-bolder ">{{ $data->kode_tender }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6 p-2">
                                            <div
                                                class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                                <div class="fs-7 text-muted fw-bolder ">Kode RUP</div>
                                                <div class="fs-5 fw-bolder ">{{ $data->kode_rup }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($data->alur == 10 && auth()->user()->tagroup_id == 4)
                                        <div>
                                            <div class="fw-bold mb-3">Delegasikan paket ke pokja</div>

                                            <form
                                                action="/usulan-tender/delegate/{{ Route::current()->parameter('tender_detail_id') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" name="delegasi" type="checkbox"
                                                        value="YES" id="flexSwitchChecked" />
                                                    <label class="form-check-label" for="flexSwitchChecked">
                                                        Delegasikan
                                                    </label>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-sm btn-light-primary">
                                                        Submit
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    @endif
                                    @if ($data->alur == 11 && auth()->user()->tagroup_id == 3)
                                        <div>
                                            <div class="fw-bold mb-3">Apakah paket telah tayang di LPSE</div>

                                            <form
                                                action="/usulan-tender/deploy/{{ Route::current()->parameter('tender_detail_id') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" name="delegasi" type="checkbox"
                                                        value="YES" id="flexSwitchChecked" />
                                                    <label class="form-check-label" for="flexSwitchChecked">
                                                        Telah Tayang
                                                    </label>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-sm btn-light-primary">
                                                        Submit
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    @endif
                                @else
                                    <img src="/images/notFound.png" class="img h-70px mt-3" />
                                @endif
                            @endif
                        </div>

                       
                        @if ($data->alur == 3)
                            @if (auth()->user()->tagroup_id == 3)
                                <form action="/usulan-tender/st/{{ Route::current()->parameter('tender_detail_id') }}"
                                    method="POST" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <label class="fs-3 mb-3">Form Surat Tugas</label>
                                    <div class="separator mb-3"></div>
                                    <input hidden ref="surat_st" @change="updateFileName($event,'surat_st_name')"
                                        type="file" name="surat_st" />
                                    <div v-if="surat_st_name"
                                        class="image-input d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                        <label @click="openFilePicker('surat_st')"
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="hidden" name="avatar_remove">
                                            <!--end::Inputs-->
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <img class="scale-hover mw-50px mw-lg-75px"
                                            data-bs-target="#kt_modal_new_card"
                                            @click="pathmodalactive='storage/surat_usulan/'+tenderData.file_surat_usulan"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                            style="cursor: pointer" src="/assets/media/svg/files/pdf.svg"
                                            alt="image">
                                        <span class="w-75 mt-3 text-center text-2-row text-wrap"
                                            v-html="file_surat_usulan_name"></span>
                                    </div>
                                    <div v-else @click="openFilePicker('surat_st')" style="cursor: pointer"
                                        class="card h-75 flex-center bg-light-primary border-primary border border-dashed p-8 mb-4">

                                        <img src="/assets/media/svg/files/upload.svg" class="h-20px" alt="">
                                        <a href="#" class=" fs-6 fw-bolder mb-2">File Upload</a>

                                    </div>

                                    <label class="mb-3 required">Nomor Surat Tugas</label>
                                    <input name="nomor_st" value="{{ @old('nomor_st') }}"
                                        class="form-control {{ $errors->has('nomor_st') ? 'is-invalid' : 'mb-3' }}" />
                                    @error('nomor_st')
                                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                    @enderror
                                    <label class="mb-3 required">Tanggal Surat Tugas</label>
                                    <input type="date" value="{{ @old('tgl_st') }}" name="tgl_st"
                                        id="kt_datepicker_1"
                                        class="form-control form-control-solid {{ $errors->has('tgl_st') ? 'is-invalid' : 'mb-3' }}" />
                                    @error('tgl_st')
                                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                    @enderror
                                    <label class="mb-3 required">Anggota Pokja</label>
                                    <select name="anggota[]"
                                        class="form-select form-select-solid {{ $errors->has('anggota') ? 'is-invalid' : 'mb-3' }}"
                                        multiple="multiple" data-control="select2"
                                        data-placeholder="Select an option" data-allow-clear="true">
                                        <option></option>
                                        @foreach ($anggotas as $anggota)
                                            <option value="{{ $anggota->id }}">{{ $anggota->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    @error('anggota')
                                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                                    @enderror


                                    <div class="d-flex justify-content-end">

                                        <button type="submit" class="btn btn-sm btn-light-primary">Simpan</button>
                                    </div>
                                </form>
                            @endif
                        @endif

                        <div class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                            <label class="fs-4 fw-bolder mb-3">Unggahan Berkas</label>
                            <div class="separator mb-3"></div>
                            <div
                                    class="d-flex align-items-center border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                    @if (!$data->file_lap_hpk)
                                    <img src="/images/notFound.png" class="img h-70px" />
                                @else
                                    <img class="scale-hover mw-50px mw-lg-75px"
                                        data-bs-target="#kt_modal_new_card"
                                        @click="pathmodalactive='storage/_upload/'+'{{ $data->file_lap_hpk }}'"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                        style="cursor: pointer" src="/assets/media/svg/files/pdf.svg"
                                        alt="image">
                                @endif
                                <div class="fs-5 fw-bolder ms-3">
                                    Laporan Hasil Penandatanganan Kontrak
                                </div>
                            </div>
                            <div
                                    class="d-flex align-items-center border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                    @if (!$data->file_spk)
                                    <img src="/images/notFound.png" class="img h-70px" />
                                @else
                                    <img class="scale-hover mw-50px mw-lg-75px"
                                        data-bs-target="#kt_modal_new_card"
                                        @click="pathmodalactive='storage/_upload/'+'{{ $data->file_spk }}'"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                        style="cursor: pointer" src="/assets/media/svg/files/pdf.svg"
                                        alt="image">
                                @endif
                                <div class="fs-5 fw-bolder ms-3">
                                    Surat Perjanjian Kontrak
                                </div>
                            </div>
                            @if ($data->alur == 6 && auth()->user()->tagroup_id == 5)
                                <form action="/usulan-tender/ba/{{ Route::current()->parameter('tender_detail_id') }}"
                                    method="POST" enctype="multipart/form-data" class="form-control">
                                    @csrf
                                    <input hidden ref="ba_kaji_ulang"
                                        @change="updateFileName($event,'ba_kaji_ulang_name')" type="file"
                                        name="ba_kaji_ulang" />
                                    <div v-if="ba_kaji_ulang_name"
                                        class="image-input d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                        <label @click="openFilePicker('ba_kaji_ulang')"
                                            class="btn btn-icon btn-circle  w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--end::Inputs-->
                                        </label>

                                        <img class="scale-hover mw-50px mw-lg-75px"
                                            data-bs-target="#kt_modal_new_card"
                                            @click="openFilePicker('ba_kaji_ulang')" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_new_card" style="cursor: pointer"
                                            src="/assets/media/svg/files/pdf.svg" alt="image">
                                        <span class="w-75 mt-3 text-center text-2-row text-wrap"
                                            v-html="ba_kaji_ulang_name"></span>
                                    </div>
                                    <div v-else @click="openFilePicker('ba_kaji_ulang')" style="cursor: pointer"
                                        class="card h-75 flex-center {{ $errors->has('ba_kaji_ulang') ? 'bg-light-danger border-danger' : 'bg-light-primary border-primary' }} border border-dashed p-8 mb-4">

                                        <img src="/assets/media/svg/files/upload.svg" class="h-20px" alt="">
                                        <a href="#" class=" fs-6 fw-bolder mb-2">Unggah Berita Acara Kaji
                                            Ulang</a>
                                        @error('ba_kaji_ulang')
                                            <div class="text-center invalid-feedback d-block mb-3">{{ $message }}
                                            </div>
                                        @enderror


                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-light-primary">Unggah</button>
                                    </div>
                                </form>
                            @else
                                <div
                                    class="d-flex align-items-center border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                    @if (!$data->ba_kaji_ulang)
                                        <img src="/images/notFound.png" class="img h-70px" />
                                    @else
                                        <img class="scale-hover mw-50px mw-lg-75px"
                                            data-bs-target="#kt_modal_new_card"
                                            @click="pathmodalactive='storage/ba_kaji/'+'{{ $data->ba_kaji_ulang }}'"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                            style="cursor: pointer" src="/assets/media/svg/files/pdf.svg"
                                            alt="image">
                                    @endif
                                    <div class="fs-5 fw-bolder ms-3">
                                        Berkas Berita Acara Kaji Ulang
                                    </div>

                                </div>
                                @if ($data->alur == 12 && auth()->user()->tagroup_id == 5)
                                    <form
                                        action="/usulan-tender/ba-choose/{{ Route::current()->parameter('tender_detail_id') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input hidden ref="ba_hasil_pemilihan"
                                            @change="updateFileName($event,'ba_hasil_pemilihan_name')" type="file"
                                            name="ba_hasil_pemilihan" />
                                        <div v-if="ba_hasil_pemilihan_name"
                                            class="image-input d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                            <label @click="openFilePicker('ba_hasil_pemilihan')"
                                                class="btn btn-icon btn-circle  w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="" data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--end::Inputs-->
                                            </label>

                                            <img class="scale-hover mw-50px mw-lg-75px"
                                                data-bs-target="#kt_modal_new_card"
                                                @click="openFilePicker('ba_hasil_pemilihan')" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_new_card" style="cursor: pointer"
                                                src="/assets/media/svg/files/pdf.svg" alt="image">
                                            <span class="w-75 mt-3 text-center text-2-row text-wrap"
                                                v-html="ba_hasil_pemilihan_name"></span>
                                        </div>
                                        <div v-else @click="openFilePicker('ba_hasil_pemilihan')"
                                            style="cursor: pointer"
                                            class="card h-75 flex-center {{ $errors->has('ba_hasil_pemilihan') ? 'bg-light-danger border-danger' : 'bg-light-primary border-primary' }} border border-dashed p-8 mb-4">

                                            <img src="/assets/media/svg/files/upload.svg" class="h-20px"
                                                alt="">
                                            <a href="#" class=" fs-6 fw-bolder mb-2">Unggah Berita Acara Hasil
                                                Pemilihan
                                            </a>
                                            @error('ba_hasil_pemilihan')
                                                <div class="text-center invalid-feedback d-block mb-3">{{ $message }}
                                                </div>
                                            @enderror


                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-sm btn-light-primary">Unggah</button>
                                        </div>
                                    </form>
                                @else
                                    <div
                                        class="d-flex align-items-center border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                                        @if (!$data->ba_hasil_pemilihan)
                                            <img src="/images/notFound.png" class="img h-70px" />
                                        @else
                                            <img class="scale-hover mw-50px mw-lg-75px"
                                                data-bs-target="#kt_modal_new_card"
                                                @click="pathmodalactive='storage/ba_hasil/'+'{{ $data->ba_kaji_ulang }}'"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                                style="cursor: pointer" src="/assets/media/svg/files/pdf.svg"
                                                alt="image">
                                        @endif
                                        <div class="fs-5 fw-bolder ms-3">
                                            Berita Acara Hasil Pemilihan
                                        </div>

                                    </div>
                                @endif
                                @if ($data->alur == 12 && auth()->user()->tagroup_id == 5)
                                @endif
                            @endif
                        </div>




                        <div class="border border-gray-300 border-dashed rounded w-100 py-5 px-4 mb-3">
                            <div class="fw-bolder fs-4 mb-3">Surat Tugas</div>
                            <div class="separator mb-4"></div>
                            @if (!$data->nomor_st)
                                <img src="/images/notFound.png" class="img h-70px" />
                            @else
                                <div class="d-flex align-items-center">
                                    <img class="scale-hover mw-50px mw-lg-75px me-5"
                                        data-bs-target="#kt_modal_new_card"
                                        @click="pathmodalactive='storage/surat_st/'+{{ $data->nomor_st }}"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card"
                                        style="cursor: pointer" src="/assets/media/svg/files/pdf.svg" alt="image">
                                    <div>
                                        <div class="border border-gray-300 border-dashed rounded w-100 py-3 px-4 mb-3">
                                            <div>Nomor Surat Tugas : </div>
                                            <div class="text-gray-800 text-hover-primary fs-4  fw-bolder me-3">
                                                {{ $data->nomor_st ?? 'Surat tugas belum di tentukan' }}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded w-100 py-3 px-4">
                                            <div>Tanggal Surat Tugas : </div>
                                            <div class="fw-bolder fs-5">
                                                {{ $data->tgl_st ?? 'Tanggal surat tugas belum di tentukan' }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
                <!--begin::Details-->

                <!--end::Details-->
                <div class="fs-3 fw-bold mb-5">Berkas Tender</div>
                <div class="separator"></div>
                <div class="d-flex p-5">
                    @foreach ($data->usulanTenderDetailDoc as $doc)
                        <div
                            class="border border-gray-300 border-dashed text-center rounded w-125px py-3 px-4 me-6 mb-3">
                            <img class="scale-hover mw-50px mw-lg-75px" data-bs-target="#kt_modal_new_card"
                                @click="pathmodalactive='storage/berkas/'+'{{ $doc->berkas }}'"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_card" style="cursor: pointer"
                                src="/assets/media/svg/files/pdf.svg" alt="image">
                            <label class="mt-3">{{ $doc->nama_berkas }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="fs-3 fw-bold mb-5">Usulan Anggota Pokja</div>
                <div class="separator"></div>
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <td>Nip & Nama</td>
                                <td>Jabatan</td>
                                <td>No Sertifikat PBJ</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->usulanTender->usulanTenderUsulPokja as $pokja)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <!--begin:: Avatar -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                <div class="symbol-label fs-3 bg-light-danger text-danger">
                                                    {{ ($pokja->nama_lengkap ?? '-')[0] }}</div>
                                            </a>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                class="text-gray-800 fw-bolder mb-1">{{ $pokja->nama_lengkap ?? '-' }}</a>
                                            <span>{{ $pokja->nip ?? '-' }}</span>
                                        </div>
                                        <!--begin::User details-->
                                    </td>
                                    <td>
                                        {{ $pokja->jabatan ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $pokja->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--begin::Nav wrapper-->

                <!--end::Nav wrapper-->
            </div>
        </div>
    </section>

</x-app-layout>
