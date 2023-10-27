<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <div class="card-header border-0 pt-5">
            <div class="card-header">
                <div class="d-flex flex-stack">
                    <div>
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
                                        
                                        // Set nilai awal pada elemen Select2
                                        selectElement.value = '{{ request('tm_unitkerja_id') }}';
                                        
                                        // Trigger event change agar Select2 memperbarui tampilan
                                        var event = new Event('change');
                                        selectElement.dispatchEvent(event);
                                    </script>
                                    <form method="GET" action="">
                                        @csrf
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Unit Kerja:</label>
                                            <div>
                                                <select 
                                                id="tm_unitkerja_select"
                                                name="tm_unitkerja_id" 
                                                value="{{ request('tm_unitkerja_id') }}"
                                                    class="form-select form-select-solid" data-kt-select2="true"
                                                    data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_61484bf44d957"
                                                    data-allow-clear="true">
                                                    <option></option>
                                                    @foreach ($tm_unitkerja as $item)
                                                        <option 
                                                            value="{{ $item->id }}"
                                                            {{request('tm_unitkerja_id')==$item->id?'selected':''}}
                                                        >
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
                                    <td>{{ $item->nama_group }}</td>
                                    <td><span
                                            class="w-100 badge {{ config('params.badgecolor.' . $item->alur) }} text-wrap">{{ config('params.alur.' . $item->alur) }}</span>
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex justify-content-end flex-shrink-0">
                                            <a href="/usulan-tender-detail/{{$item->id}}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
