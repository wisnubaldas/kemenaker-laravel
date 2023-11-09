<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ThUsulanTenderDetail extends Model
{
    use HasFactory;
    protected $table = "th_usulan_tender_detail";
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
            //$model->created_unitkerja = $user->tmunitkerja_id;
            //$model->tmunitkerja_id = $user->tmunitkerja_id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
            $model->updated_date = Carbon::now();
        });
    }

    public function usulanTender()
    {
        return $this->belongsTo(ThUsulanTender::class, 'thusulantender_id', 'id');
    }

    public function usulanTenderDetailDoc()
    {
        return $this->hasMany(ThUsulanTenderDetailDoc::class, 'thusulantenderdetail_id', 'id')->orderby('tmjenistenderdoc_id');
    }

    public function tmJenisTender()
    {
        return $this->belongsTo(TmJenisTender::class, 'tmjenistender_id', 'id');
    }

    public function usulanTenderPokja()
    {
        return $this->hasMany(ThUsulanTenderPokja::class, 'thusulantenderdetail_id', 'id');
    }

    // Relasi dengan TmUnitKerja mungkin tidak terlihat dalam kueri SQL Anda
    public function usulanTenderUnitKerja()
    {
        return $this->belongsTo(TmUnitKerja::class, 'unit_kerja_id', 'id');
    }
    public function usulanTenderAlur()
    {
        return $this->hasMany(ThUsulanTenderAlur::class, 'thusulantenderdetail_id', 'id');
    }
    public function basequery($request,$tipe_tender){
        $detailusulanlist = $this->getCompleteData();
        $user = Auth::user();
        $role = $user->tagroup_id;
        switch ($role) {
            case 1:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
            case 2:
                $detailusulanlist
                    ->where('th_usulan_tender.tmunitkerja_id', $user->tmunitkerja_id)
                    ->where('th_usulan_tender.created_by', $user->id);
                break;
            case 5:
                $detailusulanlist
                    ->join('th_usulan_tender_pokja', function ($join) use ($user) {
                        $join->on('th_usulan_tender_pokja.thusulantenderdetail_id', '=', 'th_usulan_tender_detail.id')
                            ->where('th_usulan_tender_pokja.thusulananggotapokja_id', '=', $user->thanggotapokja_id);
                    });
                break;
        }
        $title=["Usulan Tender","Usulan Tender Seleksi","Usulan Tender Dikecualikan"];
        $data = [
            "title" => $title[$tipe_tender],
            "tipe_tender"=>$tipe_tender,
            "draft_count"=>(new ThUsulanTender())->getdraft($user->tmunitkerja_id, $user->id)->where('th_usulan_tender.tipe_tender', $tipe_tender)
            ->orderByDesc('th_usulan_tender.created_date')->count(),
            "data" =>
            $detailusulanlist
                ->where('th_usulan_tender.tipe_tender', $tipe_tender)
                ->when($request->input('tm_unitkerja_id'), function ($query, $tm_unitkerja_id) {
                    return $query->where('th_usulan_tender.tmunitkerja_id', $tm_unitkerja_id);
                })
                ->when($request->input('no_surat_usulan'), function ($query, $no_surat_usulan) {
                    return $query->where('th_usulan_tender.no_surat_usulan', 'like', '%' . $no_surat_usulan . '%');
                })
                ->when($request->input('nama_tender'), function ($query, $nama_tender) {
                    return $query->where('th_usulan_tender_detail.nama_tender', 'like', '%' . $nama_tender . '%');
                })
                ->orderBy('th_usulan_tender_detail.updated_date', 'DESC')
                ->paginate(20),
            "tm_unitkerja" => (new TmUnitkerja())->getSortedUnitKerja()

        ];
        return $data;
    }
    public function getCompleteData()
    {
        return $this->select(
            'th_usulan_tender_detail.*',
            'th_usulan_tender.no_surat_usulan',
            'th_usulan_tender.tipe_tender',
            'th_usulan_tender.keterangan',
            'ta_group.nama_group',
            'tm_unitkerja.unitkerja',
            'tm_jenis_tender.jenis_tender'
        )
            ->with([
                'usulanTenderAlur' => function ($query) {
                    $query->orderBy('created_date', 'desc');
                },
                'usulanTenderAlur.user'
            ])
            ->leftJoin('th_usulan_tender', 'th_usulan_tender_detail.thusulantender_id', '=', 'th_usulan_tender.id')
            ->leftJoin('tm_unitkerja', 'th_usulan_tender.tmunitkerja_id', '=', 'tm_unitkerja.id')
            ->leftJoin('tm_jenis_tender', 'th_usulan_tender_detail.tmjenistender_id', '=', 'tm_jenis_tender.id')
            ->leftJoin('ta_group', 'th_usulan_tender_detail.posisi', '=', 'ta_group.id')
            ->whereNotNull('th_usulan_tender.alur')
            ->whereNotNull('th_usulan_tender.posisi');
    }
}
