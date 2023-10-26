<x-app-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>
    <section>
        <div class="card-header border-0 pt-5">
            <div class="card-body">
                <div class="table-responsive">
            <table id="example" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" style="width:100%">
                <thead>
                    <tr class="fw-bolder text-muted">
                        <th>Unit Kerja</th>
                        <th>Nomor Surat Usulan</th>
                        <th>Nama tender</th>
                        <th>Jenis Tender</th>
                        <th>Posisi</th>
                        <th>Alur</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011-04-25</td>
                        <td>$320,800</td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011-07-25</td>
                        <td>$170,750</td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009-01-12</td>
                        <td>$86,000</td>
                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012-03-29</td>
                        <td>$433,060</td>
                    </tr>
                </tbody>
            </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
