<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,
    'setpagesize' => 10,
    'setmaxButtonCount' => 5,
    'btnupdate' => 'Ubah Data',
    'btndelete' => 'Hapus Data',
    'form-title'=>[
        0=>'Verifikasi Usulan Tender',
        7=>'Verifikasi Berita Acara Kaji Ulang',
        13=>'Verifikasi Berita Acara Hasil Pemilihan'
    ],
    'status' => [
        1 => 'Aktif',
        0 => 'Inaktif',
    ],
    'listkeadaan' => [
        '1' => 'Pengajuan',
        '2' => 'Terima',
        '3' => 'Tolak',
    ],
    'listkondisi' => [
        '0' => 'Pengajuan',
        '1' => 'Aktif',
        '2' => 'Tolak',
    ],
    'keadaan' => [
        '2' => 'Tolak',
        '3' => 'Terima',
    ],
    'posisi' => [
        2 => 'Ppk',
        3 => 'Sekretariat',
        4 => 'Kepala ukpbj',
        5 => 'Pokja',
    ],
    'alur' => [
        '' => 'Draft Usulan Tender',
        0 => 'Usulan Tender Dikirimkan',
        1 => 'Verifikasi Berkas Usulan Tender dan Input Surat Tugas',
        2 => 'Sekretariat menolak Usulan Tender',
        3 => 'Sekretariat menerima Usulan Tender dan memilih anggota pokja',
        4 => 'Kepala UKPBJ mem-verikasi ST dan anggota pokja',
        5 => 'Kepala UKPBJ menolak ST dan anggota pokja',
        6 => 'Unggah Berita Acara Kaji Ulang',
        7 => 'Verifikasi Berita Acara Kaji Ulang',
        8 => 'Sekretariat menolak BA Kaji Ulang Dari Pokja',
        9 => 'Input Kode Tender',
        10 => 'Delegasi Paket ke Kelompok Kerja Pemilihan',
        11 => 'Verifikasi Paket Tayang pada LPSE',
        12 => 'Paket Tayang pada LPSE dan Unggah Berita Acara Hasil Pemilihan',
        13 => 'Verifikasi Berita Acara Hasil Pemilihan',
        14 => 'PPK Menolak BAHP dari Pokja',
        15 => 'Unggah Hasil Penandatanganan Kontrak',
        16 => 'Verifikasi Hasil Penandatanganan Kontrak',
        17 => 'Sekretariat menolak Laporan hasil penandatanganan Kontrak dari PPK',
        18 => 'Tender Telah Selesai'
    ],
    'base-bg-color'=>[
        0=>'bg-primary',
        1=>'bg-success',
        2=>'bg-warning',
        3=>'bg-info',
        4=>'bg-secondary',
        5=>'bg-dark',
    ],
    'badgecolor' => [
        '' => 'badge-secondary',  // Untuk Draft Usulan Tender
        0 => 'badge-light-primary', // Untuk Usulan Tender Dikirimkan
        1 => 'badge-light-primary', // Untuk Verifikasi Berkas Usulan Tender dan Input Surat Tugas
        2 => 'badge-light-danger',  // Untuk Sekretariat menolak Usulan Tender
        3 => 'badge-light-success', // Untuk Sekretariat menerima Usulan Tender dan memilih anggota pokja
        4 => 'badge-light-primary', // Untuk Kepala UKPBJ mem-verikasi ST dan anggota pokja
        5 => 'badge-light-danger',  // Untuk Kepala UKPBJ menolak ST dan anggota pokja
        6 => 'badge-light-primary', // Untuk Unggah Berita Acara Kaji Ulang
        7 => 'badge-light-primary', // Untuk Verifikasi Berita Acara Kaji Ulang
        8 => 'badge-light-danger',  // Untuk Sekretariat menolak BA Kaji Ulang Dari Pokja
        9 => 'badge-light-primary', // Untuk Input Kode Tender
        10 => 'badge-light-primary', // Untuk Delegasi Paket ke Kelompok Kerja Pemilihan
        11 => 'badge-light-primary', // Untuk Verifikasi Paket Tayang pada LPSE
        12 => 'badge-light-primary', // Untuk Paket Tayang pada LPSE dan Unggah Berita Acara Hasil Pemilihan
        13 => 'badge-light-primary', // Untuk Verifikasi Berita Acara Hasil Pemilihan
        14 => 'badge-light-danger', // Untuk PPK Menolak BAHP dari Pokja
        15 => 'badge-light-primary', // Untuk Unggah Hasil Penandatanganan Kontrak
        16 => 'badge-light-primary', // Untuk Verifikasi Hasil Penandatanganan Kontrak
        17 => 'badge-light-danger', // Untuk Sekretariat menolak Laporan hasil penandatanganan Kontrak dari PPK
        18 => 'badge-light-success' // Untuk Tender Telah Selesai
    ],
    'dashboardPallete'=>[
        0 => [
            "bg" => "bg-light-primary",
            "txt" => "text-primary",
            "border" => "border-primary",
            "icon-color"=>"svg-icon-primary ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M11.8 5.2L17.7 8.6V15.4L11.8 18.8L5.90001 15.4V8.6L11.8 5.2ZM11.8 2C11.5 2 11.2 2.1 11 2.2L3.8 6.4C3.3 6.7 3 7.3 3 7.9V16.2C3 16.8 3.3 17.4 3.8 17.7L11 21.9C11.3 22 11.5 22.1 11.8 22.1C12.1 22.1 12.4 22 12.6 21.9L19.8 17.7C20.3 17.4 20.6 16.8 20.6 16.2V7.9C20.6 7.3 20.3 6.7 19.8 6.4L12.6 2.2C12.4 2.1 12.1 2 11.8 2Z" fill="black"/>
            <path d="M11.8 8.69995L8.90001 10.3V13.7L11.8 15.3L14.7 13.7V10.3L11.8 8.69995Z" fill="black"/>
            </svg>'
        ],
        1 => [
            "bg" => "bg-white",
            "txt" => "text-dark",
            "border" => "border-dark",
            "icon-color"=>"svg-icon-dark ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M7 20.5L2 17.6V11.8L7 8.90002L12 11.8V17.6L7 20.5ZM21 20.8V18.5L19 17.3L17 18.5V20.8L19 22L21 20.8Z" fill="black"/>
            <path d="M22 14.1V6L15 2L8 6V14.1L15 18.2L22 14.1Z" fill="black"/>
            </svg>'
        ],
        2 => [
            "bg" => "bg-light-success",
            "txt" => "text-success",
            "border" => "border-success",
            "icon-color"=>"svg-icon-success ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M22 8H8L12 4H19C19.6 4 20.2 4.39999 20.5 4.89999L22 8ZM3.5 19.1C3.8 19.7 4.4 20 5 20H12L16 16H2L3.5 19.1ZM19.1 20.5C19.7 20.2 20 19.6 20 19V12L16 8V22L19.1 20.5ZM4.9 3.5C4.3 3.8 4 4.4 4 5V12L8 16V2L4.9 3.5Z" fill="black"/>
            <path d="M22 8L20 12L16 8H22ZM8 16L4 12L2 16H8ZM16 16L12 20L16 22V16ZM8 8L12 4L8 2V8Z" fill="black"/>
            </svg>'
        ],
        3 => [
            "bg" => "bg-light-danger",
            "txt" => "text-danger",
            "border" => "border-danger",
            "icon-color"=>"svg-icon-danger ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M8.70001 6C8.10001 5.7 7.39999 5.40001 6.79999 5.10001C7.79999 4.00001 8.90001 3 10.1 2.2C10.7 2.1 11.4 2 12 2C12.7 2 13.3 2.1 13.9 2.2C12 3.2 10.2 4.5 8.70001 6ZM12 8.39999C13.9 6.59999 16.2 5.30001 18.7 4.60001C18.1 4.00001 17.4 3.6 16.7 3.2C14.4 4.1 12.2 5.40001 10.5 7.10001C11 7.50001 11.5 7.89999 12 8.39999Z" fill="black"/>
            <path d="M7 20C7 20.2 7 20.4 7 20.6C6.2 20.1 5.49999 19.6 4.89999 19C4.59999 18 4.00001 17.2 3.20001 16.6C2.80001 15.8 2.49999 15 2.29999 14.1C4.99999 14.7 7 17.1 7 20ZM10.6 9.89995C8.70001 8.09995 6.39999 6.89996 3.79999 6.29996C3.39999 6.89996 2.99999 7.49995 2.79999 8.19995C5.39999 8.59995 7.7 9.79996 9.5 11.6C9.8 10.9 10.2 10.3999 10.6 9.89995ZM2.20001 10.1C2.10001 10.7 2 11.4 2 12C2 12 2 12 2 12.1C4.3 12.4 6.40001 13.7 7.60001 15.6C7.80001 14.8 8.09999 14.0999 8.39999 13.3999C6.89999 11.5999 4.70001 10.4 2.20001 10.1ZM11 20C11 14 15.4 8.99996 21.2 8.09996C20.9 7.39996 20.6 6.79995 20.2 6.19995C13.8 7.49995 9 13.0999 9 19.8999C9 20.3999 9.00001 21 9.10001 21.5C9.80001 21.7 10.5 21.7999 11.2 21.8999C11.1 21.2999 11 20.7 11 20ZM19.1 19C19.4 18 20 17.2 20.8 16.6C21.2 15.8 21.5 15 21.7 14.1C19 14.7 16.9 17.1 16.9 20C16.9 20.2 16.9 20.4 16.9 20.6C17.8 20.2 18.5 19.6 19.1 19ZM15 20C15 15.9 18.1 12.6 22 12.1C22 12.1 22 12.1 22 12C22 11.3 21.9 10.7 21.8 10.1C16.8 10.7 13 14.9 13 20C13 20.7 13.1 21.2999 13.2 21.8999C13.9 21.7999 14.5 21.7 15.2 21.5C15.1 21 15 20.5 15 20Z" fill="black"/>
            </svg>'
        ],
        4 => [
            "bg" => "bg-light-warning",
            "txt" => "text-warning",
            "border" => "border-warning",
            "icon-color"=>"svg-icon-warning ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M8 22C7.4 22 7 21.6 7 21V9C7 8.4 7.4 8 8 8C8.6 8 9 8.4 9 9V21C9 21.6 8.6 22 8 22Z" fill="black"/>
            <path opacity="0.3" d="M4 15C3.4 15 3 14.6 3 14V6C3 5.4 3.4 5 4 5C4.6 5 5 5.4 5 6V14C5 14.6 4.6 15 4 15ZM13 19V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V19C11 19.6 11.4 20 12 20C12.6 20 13 19.6 13 19ZM17 16V5C17 4.4 16.6 4 16 4C15.4 4 15 4.4 15 5V16C15 16.6 15.4 17 16 17C16.6 17 17 16.6 17 16ZM21 18V10C21 9.4 20.6 9 20 9C19.4 9 19 9.4 19 10V18C19 18.6 19.4 19 20 19C20.6 19 21 18.6 21 18Z" fill="black"/>
            </svg>'
        ],
        5 => [
            "bg" => "bg-light-info",
            "txt" => "text-info",
            "border" => "border-info",
            "icon-color"=>"svg-icon-info ",
            "icon"=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M11.425 7.325C12.925 5.825 15.225 5.825 16.725 7.325C18.225 8.825 18.225 11.125 16.725 12.625C15.225 14.125 12.925 14.125 11.425 12.625C9.92501 11.225 9.92501 8.825 11.425 7.325ZM8.42501 4.325C5.32501 7.425 5.32501 12.525 8.42501 15.625C11.525 18.725 16.625 18.725 19.725 15.625C22.825 12.525 22.825 7.425 19.725 4.325C16.525 1.225 11.525 1.225 8.42501 4.325Z" fill="black"/>
            <path d="M11.325 17.525C10.025 18.025 8.425 17.725 7.325 16.725C5.825 15.225 5.825 12.925 7.325 11.425C8.825 9.92498 11.125 9.92498 12.625 11.425C13.225 12.025 13.625 12.925 13.725 13.725C14.825 13.825 15.925 13.525 16.725 12.625C17.125 12.225 17.425 11.825 17.525 11.325C17.125 10.225 16.525 9.22498 15.625 8.42498C12.525 5.32498 7.425 5.32498 4.325 8.42498C1.225 11.525 1.225 16.625 4.325 19.725C7.425 22.825 12.525 22.825 15.625 19.725C16.325 19.025 16.925 18.225 17.225 17.325C15.425 18.125 13.225 18.225 11.325 17.525Z" fill="black"/>
            </svg>'
        ],
    ],
    'jejak' => [
        0 => 'Usulan Tender Dikirimkan',
        1 => 'Verifikasi Berkas Usulan Tender dan Input Surat Tugas',
        2 => 'Sekretariat menolak Usulan Tender',
        3 => 'Mohon untuk meng-isi nomor ST, tanggal ST, memilih anggota pokja dan Nomor Dipa',
        4 => 'Mohon untuk mem-verikasi ST dan anggota pokja',
        5 => 'Kepala UKPBJ menolak ST dan anggota pokja',
        6 => 'Unggah Berita Acara Kaji Ulang',
        7 => 'Verifikasi Berita Acara Kaji Ulang',
        8 => 'Sekretariat menolak BA Kaji Ulang Dari Pokja',
        9 => 'Input Kode Tender',
        10 => 'Delegasi Paket ke Kelompok Kerja Pemilihan',
        11 => 'Verifikasi Paket Tayang pada LPSE',
        12 => 'Paket Tayang pada LPSE dan Unggah Berita Acara Hasil Pemilihan',
        13 => 'Verifikasi Berita Acara Hasil Pemilihan',
        14 => 'PPK Menolak BAHP dari Pokja',
        15 => 'PPK meng-Unggah Hasil Penandatanganan Kontrak dan mengirimkan ke Sekretariat',
        16 => 'Sekretariat mem-verifikasi Hasil Penandatanganan Kontrak',
        17 => 'Sekretariat menolak Laporan hasil penandatanganan Kontrak dari PPK',
        18 => 'Tender Telah Selesai'
    ],
];
