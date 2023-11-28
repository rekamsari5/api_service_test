<?php declare(strict_types=1);

namespace App\Repositories;

use DateTime;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Collections\CustomerCollection;

class CustomerRepository
{
    public function getCustomer($filter)
    {

        $query = DB::table('nasabah')
            ->select('*')
            ->where(function($sub_query) use ($filter) {
                if (isset($filter['name'])) {
                    $sub_query->where('name', 'like', '%' . $filter['name'] . '%');
                }
            })
            ->orderby('id', 'desc')
            ->get();

        return $query;
    }

    public function createCustomer($request) {
        $query = DB::table('nasabah')
                ->insert([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'alamat' => $request['alamat'],
                    'no_tlp' => $request['no_tlp'],
                    'nik' => $request['nik']
                ]);
        return $query;
    }

    public function updateCustomer($request) {
        $update = new DateTime('now');
        $query = DB::table('nasabah')
                ->where('id', $request['id'])
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'alamat' => $request['alamat'],
                    'no_tlp' => $request['no_tlp'],
                    'nik' => $request['nik'],
                    'updated_at' => $update
                ]);

        return $query;
    }

    public function deleteCustomer($request) {
        $query = DB::table('nasabah')
                 ->where("id", $request)
                 ->delete();

         return $query;
    }

}
