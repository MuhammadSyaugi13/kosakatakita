<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vocabularies;
use App\Models\Notifikasi;
use Carbon\Carbon;

class VocabulariesController extends Controller
{
    public function index(){
        return Inertia::render('AddVocabularies');
    }

    public function addVocabularies(Request $req){
        $insert = [];
        $tanggal_hari_ini = Carbon::now('Asia/Jakarta');
        foreach ($req->indonesia as $key => $value) {
            if($value){
                $insert[] = [
                    'user_id' => auth()->user()->id,
                    'english' => $req->english[$key],
                    'indonesia' => $value,
                    'explanation' => $req->explanation[$key],
                    'show_date' => $req->show_date,
                    "created_at" => $tanggal_hari_ini,
                    "updated_at" => $tanggal_hari_ini,
                ]; 
            };
        };
        
        Vocabularies::insert($insert);

        return back();
    }

    public function getVacabularies(Request $request)
    {
        $tanggal = $request->tanggal;
        if ($tanggal["from"] == null && $tanggal["to"] == null) {
            $tanggal_hari_ini = Carbon::now('Asia/Jakarta')->toDateString();
            $data = Vocabularies::select('indonesia', 'english', 'explanation', 'show_date')->where('show_date', $tanggal_hari_ini)->orderBy('show_date', 'desc')->get();

            return $data->groupBy('show_date');
        }else{
            $data = Vocabularies::select('indonesia', 'english', 'explanation', 'show_date')->whereBetween('show_date', [$tanggal["from"], $tanggal["to"]])->orderBy('show_date', 'desc')->get();
            
            return $data->groupBy('show_date');
        }

    }

    public function getNotification()
    {
        $tanggal_hari_ini = Carbon::now('Asia/Jakarta')->toDateString();
        // ambil data notifikasi
        $dataNotifikasi = Notifikasi::where('tanggal_tampil', $tanggal_hari_ini)->where('user_id', auth()->id());

        $allDataNotifikasi = $dataNotifikasi->first();
        // jika tidak ada data notifikasi
        if (count($dataNotifikasi->get()) == 0) {
            $dataKosakata = Vocabularies::select('indonesia', 'english', 'explanation', 'show_date')->where('show_date', $tanggal_hari_ini)->where('user_id', auth()->id())->orderBy('show_date', 'desc')->get();

            $data = [];
            foreach ($dataKosakata as $value) {
                $data[] = ["Indonesia" => $value->indonesia, "English" => $value->english];
            }
            
            $allDataNotifikasi = Notifikasi::create([
                'user_id' => auth()->id(),
                'kosakata' => json_encode($data),
                'index_tampil' => '[0,1,2,3,4]',
                'tanggal_tampil' => $tanggal_hari_ini, 
                'created_at' => $tanggal_hari_ini,
                'updated_at' => $tanggal_hari_ini
            ]);
        }

        // pilih index yang akan ditampilkan
        $all_index_tampil = json_decode($allDataNotifikasi->index_tampil, true);
        if (count($all_index_tampil) == 0) {
            $all_index_tampil = [0,1,2,3,4];
        }
        $index_tampil = rand(0, count($all_index_tampil)-1);
        $index_vocab = $all_index_tampil[$index_tampil];
        
        // hapus index pada tabel yang sudah terpilih
        $new_index_tampil = [];
        foreach($all_index_tampil as $key => $index){
            if ($key == $index_tampil) {continue;};
            $new_index_tampil[] = $all_index_tampil[$key];
        }

        // update index_tampil pada tabel notification 
        $dataUpdate = $dataNotifikasi;
        $dataUpdate->update([
            'index_tampil' => json_encode($new_index_tampil),
            'bahasa' => !$allDataNotifikasi->bahasa
        ]);
        
        // balikan data notifikasi
        $vocabularies = json_decode($allDataNotifikasi->kosakata, true);
        return array_merge($vocabularies[$index_vocab], ["bahasa" => ($allDataNotifikasi->bahasa) ? 'Indonesia' : 'English']);

    }
}
