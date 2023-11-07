<?php

namespace Database\Seeders;

use App\Models\TmJenisTender;
use App\Models\TmJenisTenderDoc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTenderDocsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names=[
            [
                "Harga Perkiraan Sendiri (HPS)",
                "Gambar",
                "Spesifikasi Teknis/KAK",
                "Rancangan Kontrak"
            ],[
                "Harga Perkiraan Sendiri (HPS)",
                "Detailed Engineering Design (DED)",
                "Spesifikasi Teknis",
                "Rancangan Kontrak"
            ],[
                "Harga Perkiraan Sendiri (HPS)",
                "KAK",
                "Rancangan Kontrak"
            ],[
                "Harga Perkiraan Sendiri (HPS)",
                "Spesifikasi Teknis/KAK",
                "Rancangan Kontrak"
            ]
        ];
        $jenistender=TmJenisTender::all();
        $i=0;
        foreach($jenistender as $jenis){
            foreach($names[$i] as $name){
                $doc = new TmJenisTenderDoc();
                $doc->tmjenistender_id=$jenis->id;
                $doc->nama_doc=$name;
                $doc->tipe_doc='pdf';
                $doc->save();
            }
            $i++;
        }
    }
}
