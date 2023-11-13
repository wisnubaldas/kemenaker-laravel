<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="card-header border-0 pt-5">
            @include('components.logdrawer')
            <div class="card-header">
                <div class="d-flex flex-stack">
                    
                    <div class="">
                        @if(auth()->user()->tagroup_id==2)
                        @include('components.newtabusulan')
                        @endif
                    </div>
                  
                    <div class="d-flex align-items-center py-1">
                        <div class="me-4">
                            <!--begin::Menu-->
                            <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Filter</a>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_61484bf44d957">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->
                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <script>
                                        // Dapatkan elemen select menggunakan ID
                                        var selectElement = document.getElementById('tm_unitkerja_select');
                                        if(selectElement){
                                        // Set nilai awal pada elemen Select2
                                            selectElement.value = '{{ request('tm_unitkerja_id') }}';

                                        // Trigger event change agar Select2 memperbarui tampilan
                                            var event = new Event('change');
                                            selectElement.dispatchEvent(event);
                                        }
                                    </script>
                                    <form method="GET" action="">
                                        @csrf
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Unit Kerja:</label>
                                            <div>
                                                <select id="tm_unitkerja_select" name="tm_unitkerja_id"
                                                    value="{{ request('tm_unitkerja_id') }}"
                                                    class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_61484bf44d957"
                                                    data-allow-clear="true">
                                                    <option></option>
                                                    @foreach ($tm_unitkerja as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ request('tm_unitkerja_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->unitkerja }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Nomor Surat Usulan:</label>
                                            <!--end::Label-->
                                            <!--begin::Options-->
                                            <input name="no_surat_usulan" value="{{ request('no_surat_usulan') }}"
                                                class="form-control" />
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Nama Tender:</label>
                                            <!--end::Label-->
                                            <!--begin::Options-->
                                            <input name="nama_tender" value="{{ request('nama_tender') }}"
                                                class="form-control" />
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <a href="/usulan-tender"
                                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true">Reset</a>
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-kt-menu-dismiss="true">Apply</button>
                                        </div>
                                    </form>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Menu-->
                        </div>
                        <select class="form-select form-select-sm form-select-solid w-70px select2-hidden-accessible"
                            data-control="select2" data-placeholder="Select Hours" data-hide-search="true"
                            data-select2-id="select2-data-10-wdu2" tabindex="-1" aria-hidden="true">
                            <option value="2" selected="selected">20</option>
                            <option value="3">50 </option>
                            <option value="4">100 </option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="example"
                        class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-0 gy-4"
                        style="width:100%">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="ps-4 rounded-start">Unit Kerja</th>
                                <th>Nomor Surat Usulan</th>
                                <th>Nama tender</th>
                                <th>Jenis Tender</th>
                                <th>Posisi</th>
                                <th class="text-center">Alur</th>
                                <th class="w-25px pe-4 text-end rounded-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td class="ps-4">{{ $item->unitkerja }}</td>
                                    <td>{{ $item->no_surat_usulan }}</td>
                                    <td>{{ $item->nama_tender }}</td>
                                    <td>{{ $item->jenis_tender }}</td>
                                    <td class=" {{ ($item->posisi== 4 && $item->alur == 3 && auth()->user()->tagroup_id==3) ?'text-danger fw-bolder':'' }}">  
                                        @if($item->posisi== 4 && $item->alur == 3) 
                                            {{config('params.posisi.3');}}
                                        @else
                                           {{ config('params.posisi.'.$item->posisi);}}
                                        @endif
                                         
                                            
                                            
                                        </td>
                                    <td><span @click="showlog({{$item}})" id="kt_drawer_example_basic_button" 
                                            class="btn w-100 badge {{ config('params.badgecolor.' . $item->alur) }} text-wrap">{{ config('params.alur-seleksi.' . $item->alur) }}</span>
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex justify-content-end flex-shrink-0">
                                            @if($item->alur==2&& auth()->user()->tagroup_id==2)
                                            <div @click="reSendUsulan({{ $item->id }})" class="btn btn-icon btn-light-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="black"/>
                                                        <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="black"/>
                                                        </svg>     
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            @endif
                                            <a href="/usulan-tender-detail/{{ $item->id }}"
                                                class="btn btn-icon btn-light-info btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z"
                                                            fill="black"></path>
                                                        <path opacity="0.3"
                                                            d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z"
                                                            fill="black"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            @if($item->alur<4&& auth()->user()->tagroup_id==2)
                                                <a href="/usulan-tender-detail/{{ $item->id }}" class="btn btn-icon btn-light-warning btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- @include('components.paginationbar',['data'=>$data]) --}}
                    {!! $data->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
