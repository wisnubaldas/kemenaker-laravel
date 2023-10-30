<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <script>
            var isEditDraft=@json($is_edit);
            var tenderData = @json($data);
        </script>
        <form ref="draftForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-5">
                <div class="card-body pt9 pb-0">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                        <!--begin::Image-->
                        <div class="me-2">
                            <label class="fw-bolder mb-3">Berkas</label>
                            <input hidden  ref="file_surat_usulan" @change="updateFileName" type="file" name="file_surat_usulan" />
                                <div v-if="file_surat_usulan_name||tenderData.file_surat_usulan"
                                    @click="openFilePicker('file_surat_usulan')" style="cursor: pointer"
                                    class="d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                   
                                    <img class="mw-50px mw-lg-75px" src="/assets/media/svg/files/pdf.svg"
                                        alt="image">
                                    <span class="w-75 mt-3 text-center text-2-row text-wrap" v-html="file_surat_usulan_name"></span>
                                </div>
                                <div v-else @click="openFilePicker('file_surat_usulan')" style="cursor: pointer"
                                    class="card h-75 flex-center bg-light-primary border-primary border border-dashed p-8">
                                   
                                    <img src="/assets/media/svg/files/upload.svg" class="h-20px" alt="">
                                    <a href="#" class=" fs-6 fw-bolder mb-2">File Upload</a>
                                    
                                </div>
                        </div>
                        <!--end::Image-->
                        <!--begin::Wrapper-->
                        <div class="flex-grow-1">
                            <!--begin::Head-->
                            <div class="d-flex flex-column">
                                <!--begin::Status-->
                                <div class="mb-5">
                                    <label class="d-flex fw-bolder mb-3 required">
                                        <div class="me-3">No Surat Usulan</div>
                                        @error('no_surat_usulan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </label>
                                    <input name="no_surat_usulan"
                                        class="form-control {{ $errors->has('no_surat_usulan') ? 'is-invalid' : '' }}"
                                        required 
                                        value="{{ $is_edit ? $data->no_surat_usulan : @old('no_surat_usulan') }}"
                                        />

                                </div>
                                <!--end::Status-->
                                <!--begin::Description-->
                                <div class="">
                                    <label class="fw-bolder mb-3">Keterangan</label>
                                    <textarea name="keterangan" 
                                    value="{{ $is_edit? $data->keterangan : @old('keterangan') }}"
                                    class="form-control"></textarea>
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
                <button @click="onAdd" type="button" class="btn btn-sm btn-primary">
                    <span class="svg-icon  svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3"
                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 13H13V10C13 9.4 12.6 9 12 9C11.4 9 11 9.4 11 10V13H8C7.4 13 7 13.4 7 14C7 14.6 7.4 15 8 15H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V15H16C16.6 15 17 14.6 17 14C17 13.4 16.6 13 16 13Z"
                                fill="black" />
                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                        </svg></span>
                    Tambah Tender
                </button>
            </div>
            <hr />
            <div class="card mb-5" v-for="(item,index) in tenderData.usulan_tender_details" :key="index">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-6">
                            <label class="mb-3 fw-bolder">Jenis Tender</label>
                            <select 
                            :value="isEdit?item.tmjenistender_id:''"
                            :name="`usulanTenderDetails[${index}][tmjenistender_id]`" class="form-control" >
                                <option value="">Pilih Jenis Tender</option>
                                @foreach ($jenis_tender as $item)
                                <option value="{{$item->id}}"
                                    >{{$item->jenis_tender}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-6">
                                <label  class="d-flex mb-3 fw-bolder required">
                                    <div class="me-3">Nama Tender</div>                                  
                                </label>
                            <input required 
                            :name="`usulanTenderDetails[${index}][nama_tender]`" 
                            :value="isEdit?item.nama_tender:''"
                            class="form-control" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3>Berkas Tender</h3>
                        <button @click="onAddBerkas(item)" type="button" class="btn btn-sm btn-light-primary">
                            <span class="svg-icon  svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"
                                        d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 13H13V10C13 9.4 12.6 9 12 9C11.4 9 11 9.4 11 10V13H8C7.4 13 7 13.4 7 14C7 14.6 7.4 15 8 15H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V15H16C16.6 15 17 14.6 17 14C17 13.4 16.6 13 16 13Z"
                                        fill="black" />
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                </svg></span>
                            Tambah Berkas
                        </button>
                    </div>
                    <hr />
                    <div class="row" v-for="(i,indexi) in item.usulan_tender_detail_doc">
                        <div class="col-2 mb-3">
                            <div>
                                <input :ref="`berkas_${index}_${indexi}`" hidden @change="updateDocName($event,`berkas_${index}_${indexi}`)" type="file" :name="`usulanTenderDetails[${index}][usulanTenderDetailDoc][${indexi}][berkas]`" />
                              
                                <div v-if="checkExist(`berkas_${index}_${indexi}`)||i.berkas"
                                    @click="openDocPicker('berkas_'+index+'_'+indexi)" style="cursor: pointer"
                                    class="d-flex flex-column p-3 flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-100px me-7 mb-4">
                                   
                                    <img class="mw-50px mw-lg-75px" src="/assets/media/svg/files/pdf.svg"
                                        alt="image">
                                    
                                </div>
                                <div v-else @click="openDocPicker('berkas_'+index+'_'+indexi)" style="cursor: pointer"
                                    class="card  flex-center bg-light-primary border-primary border border-dashed p-8">
                                   
                                    <img src="/assets/media/svg/files/upload.svg" class="h-20px" alt="">
                                    <a href="#" class=" fs-6 fw-bolder mb-2">File Upload</a>
                                    
                                </div>
                            </div>
                              
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-between">
                                <label class="fw-bolder mb-3">Nama Berkas</label>
                                <a href="" class="text-danger fw-bolder">Hapus</a>
                            </div>
                            <input type="text" :name="`usulanTenderDetails[${index}][usulanTenderDetailDoc][${indexi}][nama_berkas]`" 
                            :value="isEdit?i.nama_berkas:''"
                            class="form-control me-4" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" />
                                <span class="w-75 mt-3  text-2-row text-wrap" v-html="docname['berkas_'+index+'_'+indexi]"></span>


                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2>Usulan Anggota Pokja</h2>
                        <button type="button" @click="onAddAnggota" class="btn btn-sm btn-light-primary">
                            <span class="svg-icon svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                        fill="black" />
                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2"
                                        fill="black" />
                                    <path
                                        d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                        fill="black" />
                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3"
                                        fill="black" />
                                </svg></span>
                            Tambah Anggota
                        </button>
                    </div>
                    <hr />
                    <div class="row mb-3" v-for="(member,imember) in tenderData.usulan_tender_usul_pokja">
                        <div class="col-3">
                            <label class="fw-bolder mb-3">NIP</label>
                            <input 
                            :value="isEdit?member.nip:''"
                            :name="`pokja[${imember}][nip]`" class="form-control" />
                        </div>
                        <div class="col-3">
                            <label class="fw-bolder mb-3">Nama Lengkap</label>
                            <input  
                            :value="isEdit?member.nama_lengkap:''"
                            :name="`pokja[${imember}][nama_lengkap]`" class="form-control" />
                        </div>
                        <div class="col-3">
                            <label class="fw-bolder mb-3">Jabatan</label>
                            <input  
                            :value="isEdit?member.jabatan:''"
                            :name="`pokja[${imember}][jabatan]`" class="form-control" />
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-between">
                                <label class="fw-bolder mb-3">No Sertifikat PBJ</label>
                                <a href="" class="text-danger fw-bolder">Hapus</a>
                            </div>
                            <input 
                            :value="isEdit?member.keterangan:''"
                            :name="`pokja[${imember}][keterangan]`"  class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</x-app-layout>
