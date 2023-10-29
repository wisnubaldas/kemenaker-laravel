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
