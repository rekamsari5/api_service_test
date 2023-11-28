<?php declare(strict_types=1);

namespace App\Http\Controllers\V1;

use stdClass;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ParameterException;
use App\Exceptions\FailedDataException;
use App\Exceptions\InvalidRuleException;
use App\Repositories\PinjamanRepository;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\Validator;

class PinjamanController extends Controller
{
    public function __construct(PinjamanRepository $pinjamanRepository)
    {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        $this->pinjamanRepository = $pinjamanRepository;
        $this->output = new stdClass();
        $this->output->responseCode = '';
        $this->output->responseDesc = '';
    }

    public function inquirypinjaman(Request $request)
    {
        $filter = [];

        if (empty($request->all())) {
            throw new ParameterException('Parameter tidak boleh kosong');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            $error_massage = $validator->errors()->first();
            throw new ParameterException($error_massage);
        }

        $filter['name'] = $request->name;
        $result= $this->pinjamanRepository->getPinjaman($filter);

        if(count($result) < 1){
            throw new DataNotFoundException('Data Not Found');
        }


        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Success Inquiry Pinjaman Customer';
        $this->output->responseData = $result;
        return response()->json($this->output);
    }

    public function createpinjaman(Request $request){

        if (empty($request->all())) {
            throw new ParameterException('Parameter tidak boleh kosong');
        }

        $validator = Validator::make($request->all(), [
            'id_nasabah' => 'required|numeric',
            'jumlah_pinjaman' => 'required|numeric',
            'tgl_pengajuan' => 'required|date_format:Y-m-d',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            $error_massage = $validator->errors()->first();
            throw new ParameterException($error_massage);
        }

        $request = [
            "id_nasabah" => $request->id_nasabah,
            "jumlah_pinjaman" => $request->jumlah_pinjaman,
            "tgl_pengajuan" => $request->tgl_pengajuan,
            "status" => $request->status,
        ];

        $result= $this->pinjamanRepository->createPinjaman($request);
        if($result == 0){
            throw new DataNotFoundException('Data Customer Not Found');
        }
        if($result == false){
            throw new FailedDataException('Failed to insert data');
        }

        $this->output->responseCode = '00';
        $this->output->responseMessage = 'Success';
        $this->output->responseDesc = 'Success Insert Data';
        return response()->json($this->output);

    }

    public function updatepinjaman(Request $request){

        if (empty($request->all())) {
            throw new ParameterException('Parameter tidak boleh kosong');
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'jumlah_pinjaman' => 'required|numeric',
            'tgl_pengajuan' => 'required|date_format:Y-m-d',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            $error_massage = $validator->errors()->first();
            throw new ParameterException($error_massage);
        }

        $request = [
            "id" => $request->id,
            "jumlah_pinjaman" => $request->jumlah_pinjaman,
            "tgl_pengajuan" => $request->tgl_pengajuan,
            "status" => $request->status,
        ];

        $result= $this->pinjamanRepository->updatePinjaman($request);
        if($result != 1){
            throw new FailedDataException('Failed to update data');
        }

        $this->output->responseCode = '00';
        $this->output->responseMessage = 'Success';
        $this->output->responseDesc = 'Success Update Data';
        return response()->json($this->output);

    }

}
