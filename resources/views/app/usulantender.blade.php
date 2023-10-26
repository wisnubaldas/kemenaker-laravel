<x-app-layout >
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <x-slot name="ta_group">{{ $ta_group ?? '' }}</x-slot>
    <section>
        <div class="card-header border-0 pt-5">
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-row-bordered table-row-gray-100 align-middle gs-0 gy-4" style="width:100%">
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
                            @foreach($data as $item)
                            <tr>
                                <td class="ps-4">{{$item->unitkerja}}</td>
                                <td>{{$item->no_surat_usulan}}</td>
                                <td>{{$item->nama_tender}}</td>
                                <td>{{$item->jenis_tender}}</td>
                                <td>{{$item->nama_group}}</td>
                                <td><span class="w-100 badge {{ config('params.badgecolor.'.$item->alur) }} text-wrap">{{ config('params.alur.'.$item->alur)}}</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black"></path>
                                                    <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black"></path>
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
