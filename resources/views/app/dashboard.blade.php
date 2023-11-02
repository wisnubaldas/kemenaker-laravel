<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <div class="row">

            <div class="col-12">
                <div class="card mt-5">

                    <div class="card-body p-0 position-relative">

                        <div class="card-p mt-n20">
                            <div class="row g-2 row-cols-lg-6 justify-content-center">
                                <div class="col-2 border border-danger bg-light-danger px-4 py-8 rounded-2 mb-7 me-4">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <div class="d-flex align-items-end">

                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3"
                                                    d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                                    fill="black" />
                                                <path
                                                    d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <h1 class="fw-bolder text-danger text-center m-0" style="font-size: 3rem">{{$usulan}}</h1>

                                    </div>

                                    <!--end::Svg Icon-->
                                    <a href="#" class="text-danger fw-bold fs-6">Usulan Tender</a>

                                </div>

                                @php
                                    $colorPaletteIndex = 0;
                                    $colorPaletteCount = count(config('params.dashboardPallete'));
                                @endphp
                                @foreach ($tenders as $tender)
                                    @php
                                        $color = config('params.dashboardPallete')[$colorPaletteIndex % $colorPaletteCount];
                                        $colorPaletteIndex++;
                                    @endphp
                                    <div
                                        class="col-2 border {{ $color['border'] }} {{ $color['bg'] }} px-4 py-8 rounded-2 mb-7 me-4">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <div class="d-flex align-items-end">

                                            <span class="svg-icon svg-icon-3x {{ $color['icon-color'] }} d-block my-2">
                                            {!! $color['icon'] !!}
                                            </span>
                                            <h1 class="fw-bolder {{ $color['txt'] }} text-center m-0" style="font-size: 3rem">
                                                {{ $tender->jmlltender }}</h1>

                                        </div>

                                        <!--end::Svg Icon-->
                                        <a href="#"
                                            class="{{ $color['txt'] }} fw-bold fs-6">{{ $tender->jenis_tender }}</a>

                                    </div>
                                @endforeach
                             
                            </div>
                            <div class="card card-flush e-0 h-lg-100">
                             
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bolder mb-1">Tender Summary</h3>
                                        <div class="fs-6 fw-bold text-gray-400">{{$usulan}} Usulan Tender</div>
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                  
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body p-9 pt-5">
                                    <div class="row">
                                        <div class="col-8">
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Chart-->
                                        <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                                            <div
                                                class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                                                <span class="fs-2qx fw-bolder">{{$cartsum->sum('jmlltender')}}</span>
                                                <span class="fs-8 fw-bold text-gray-400">Total Tender</span>
                                            </div>
                                            <canvas 
                                            data-chart-data="{{ json_encode($chartData) }}"
                                            id="project_overview_chart" width="350" height="350"
                                                style="display: block; box-sizing: border-box; height: 175px; width: 175px;"></canvas>
                                        </div>
                                        <!--end::Chart-->
                                        <!--begin::Labels-->
                                        <div
                                            class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                            <!--begin::Label-->
                                            @php
                                            $bgindex = 0;
                                            $bgpalletecount = count(config('params.base-bg-color'));
                                            if($bgindex>$bgpalletecount){
                                                    $bgindex=0;
                                            }
                                            @endphp
                                            @foreach ($cartsum as $cart)
                                            @php
                                                $bgcolor = config('params.base-bg-color')[$bgindex];
                                               // dd($bgcolor);
                                                $bgindex++;
                                            @endphp
                                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                                <div class="bullet {{$bgcolor}} me-3"></div>
                                                <div class="text-gray-400">{{$cart->jenis_tender}}</div>
                                                <div class="ms-auto fw-bolder text-gray-700">{{$cart->jmlltender}}</div>
                                            </div>
                                            @endforeach
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Labels-->
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
