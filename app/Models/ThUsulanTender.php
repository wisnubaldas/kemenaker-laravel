<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ThUsulanTender extends Model
{
    use HasFactory;
    protected $table = "th_usulan_tender";
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // Hook creating untuk mengisi kolom-kolom secara otomatis sebelum menyimpan data
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->created_date = Carbon::now();
            $model->updated_date = Carbon::now();
            $model->created_unitkerja = $user->tmunitkerja_id;
            $model->tmunitkerja_id = $user->tmunitkerja_id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
            $model->updated_date = Carbon::now();
        });
    }
    public function tmUnitKerja()
    {
        return $this->belongsTo(TmUnitKerja::class, 'tmunitkerja_id', 'id');
    }

    public function usulanTenderDetails()
    {
        return $this->hasMany(ThUsulanTenderDetail::class, 'thusulantender_id', 'id');
    }
    public function usulanTenderUsulPokja()
    {
        return $this->hasMany(ThUsulanTenderUsulpokja::class, 'thusulantender_id', 'id');
    }
    protected $title = ["Draft Usulan Tender", "Draft Usulan Tender Seleksi", "Draft Usulan Tender Dikecualikan"];
    public function edit($tipe, $tender_id)
    {
        $data = $this::with('usulanTenderDetails.usulanTenderDetailDoc', 'usulanTenderUsulPokja')
            ->where('id', $tender_id)
            ->first();
        $data = [
            "title" => $this->title[$tipe],
            "tipe_tender" => $tipe,
            "jenis_tender" => TmJenisTender::orderby('jenis_tender')->get(),
            "is_edit" => true,
            "data" => $data
        ];
        return $data;
    }
    public function draft($tipe)
    {
        $user = Auth::user();
        $role = $user->tagroup_id;
        $detailusulanlist = $this->getdraft($user->tmunitkerja_id, $user->id);
        $to = ['/usulan-tender/new', '/usulan-tender-seleksi/new', '/usulan-tender-dikecualikan/new'];
        $editto = ['/usulan-tender/edit', '/usulan-tender-seleksi/edit', '/usulan-tender-dikecualikan/edit'];
        //dd($detailusulanlist);
        $data = [
            "title" => $this->title[$tipe],
            'link_new' => $to[$tipe],
            'link_edit' => $editto[$tipe],
            "tipe_tender" => $tipe,
            "data" => $detailusulanlist
                ->where('th_usulan_tender.tipe_tender', $tipe)
                ->orderByDesc('th_usulan_tender.created_date')
                ->paginate(20),
            "tm_unitkerja" => (new TmUnitkerja())->getSortedUnitKerja()
        ];
        return $data;
    }

    public function getdraft($unit_kerja_id, $owner_id)
    {
        return $this
            ->with('usulanTenderDetails')
            ->select('th_usulan_tender.*')
            ->leftJoin('tm_unitkerja', 'th_usulan_tender.tmunitkerja_id', '=', 'tm_unitkerja.id')
            ->whereNull('th_usulan_tender.alur')
            ->whereNull('th_usulan_tender.posisi')
            ->where('th_usulan_tender.tmunitkerja_id', $unit_kerja_id)
            ->where('th_usulan_tender.created_by', $owner_id);
    }
    public function newdraftdata($tipe_tender)
    {
        $title = ["Form Usulan Tender", "Form Usulan Tender Seleksi", "Form Usulan Tender Dikecualikan"];

        $data = [
            "title" => $title[$tipe_tender],
            "jenis_tender" => TmJenisTender::with('jenisTenderDocs')->orderby('jenis_tender')->get(),

            "tipe_tender" => $tipe_tender,
            "is_edit" => false,
            "data" => [
                "usulan_tender_details" => [
                    [
                        "usulan_tender_detail_doc" => []
                    ]
                ],
                "usulan_tender_usul_pokja" => [
                    [
                        "nip" => ""
                    ]
                ]
            ]
        ];
        return $data;
    }
    
}
