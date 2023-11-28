<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Pinjaman;
use App\Collections\PinjamanCollection;

class PinjamanRepository
{
    public function getPinjaman($filter)
    {

        $query = DB::table('pinjaman AS p')
            ->select('p.*','n.name')
            ->leftJoin('nasabah AS n','n.id','=','p.id_nasabah')
            ->where(function($sub_query) use ($filter) {
                if (isset($filter['name'])) {
                    $sub_query->where('n.name', 'like', '%' . $filter['name'] . '%');
                }
            })
            ->get();

        return $query;
    }

    public function createPinjaman($request) {
        $get = DB::table('nasabah')
                ->select('*')
                ->where('id', $request['id_nasabah'])
                ->count();

        if($get > 0){
            $query = DB::table('pinjaman')
            ->insert([
                'id_nasabah' => $request['id_nasabah'],
                'jumlah_pinjaman' => $request['jumlah_pinjaman'],
                'tgl_pengajuan' => $request['tgl_pengajuan'],
                'status' => $request['status'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return $query;
        }else{
            return $get;
        }


    }

    public function updatePinjaman($request) {
        $query = DB::table('pinjaman')
                ->where('id', $request['id'])
                ->update([
                    'jumlah_pinjaman' => $request['jumlah_pinjaman'],
                    'tgl_pengajuan' => $request['tgl_pengajuan'],
                    'status' => $request['status'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        return $query;
    }


}
