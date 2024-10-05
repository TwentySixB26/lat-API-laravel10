<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //asc atau asscending digunakan akan data urut dari a-z 
        $data = Buku::orderBy('judul' , 'asc')->get() ;  

        //untuk mengembalikan respone apa yang ingin dilakukan, dan itu berbentuk json 
        return response()->json([
            'status' => true , 
            'message' => 'data ditemukan',
            'data' => $data
        ],200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // hal apa saja yang harus dipenuhi sebelum divalidasi 
        $rules = [
            'judul' => 'required' ,
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ] ; 

        // melakukan validasi
        //$request->all() berarti mengambil semua request yang telah diisi didalam input kemudian di cocokan dengan $rules apakah sudah sesuai atau belum 
        $validator = Validator::make($request->all(),$rules) ;
        
        //ketika data tidak sesuai dengan $rules seperti judul tidak diisi 
        if ($validator->fails()) {
            return response()->json([
                'status' => false , 
                'message' => 'Gagal memasukan data' ,

                //'data' mengembalikan atau mereturn eror dari suatu validator 
                'data' => $validator->errors() 
            ]) ; 
        }

        //menghubungkan dengan table yang bernama Buku 
        $dataBuku  = new Buku ; 

        //data yang sukses validasi akan disimpan di sini 
        $dataBuku->judul = $request->judul ; 
        $dataBuku->pengarang = $request->pengarang ; 
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi ; 

        //melakukan save atau mengirim data ke API dan database
        $post = $dataBuku->save() ; 

        // mengembalikan respone yang akan di lihat oleh penguna 
        return response()->json([
            'status' => true , 
            'message' => 'Sukses memasukan data'
        ]) ; 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //mencari data berdasarkan id tertentu 
        $data = Buku::find($id) ; 

        //jika data berdasarkan id tertentu ditemukan
        if ($data) {
            //mengembalikan respone 
            return response()->json([
                'status' => true , 
                'message' => 'data ditemukan',
                'data' => $data
            ]) ; 
        } 
        //jika data berdasarkan id tertentu tidak ditemukan
        else {
            return response()->json([
                'status' => false ,
                'message' => 'data tidak ditemukan'
            ]) ;
        }
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //mencari data berdasarkan id tertentu 
        $dataBuku  = Buku::find($id);


        //jika data yang dicari berdasarkan id tertentu tidak ada
        if (empty($dataBuku)) {
            return response()->json([
                'status' =>false ,
                'message' => 'data tidak ditemukan'
            ],404) ; 
        }


        //hal apa saja yang harus dipenuhi sebelum divalidasi 
        $rules = [
            'judul' => 'required' ,
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ] ; 


        // melakukan validasi
        //$request->all() berarti mengambil semua request yang telah diisi didalam input kemudian di cocokan dengan $rules apakah sudah sesuai atau belum 
        $validator = Validator::make($request->all(),$rules) ;
        
        //ketika data tidak sesuai dengan $rules seperti judul tidak diisi maka akan mengembalikan eror dari input yang tidak sesuai isinya 
        if ($validator->fails()) {
            return response()->json([
                'status' => false , 
                'message' => 'Gagal melakukan update data' ,
                'data' => $validator->errors()
            ]) ; 
        }


        //data yang sukses divalidasi maka akan disimpan didalam variabel ini 
        $dataBuku->judul = $request->judul ; 
        $dataBuku->pengarang = $request->pengarang ; 
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi ; 

        //melakukan save atau mengirim data ke API dan database
        $post = $dataBuku->save() ; 

        //mereturn dan akan menghasilkan respone jika data berhasil di update
        return response()->json([
            'status' => true , 
            'message' => 'Sukses melakukan update data'
        ]) ; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //mengambil data berdasarkan id tertentu 
        $dataBuku  = Buku::find($id);


        //jika data yang dicari berdasarkan id tertentu tidak ada
        if (empty($dataBuku)) {
            return response()->json([
                'status' =>false ,
                'message' => 'data tidak ditemukan'
            ],404) ; 
        }


        //menghapus data 
        $post = $dataBuku->delete() ; 


        // mereturn respone yang akan diperoleh jika data berhasil dihapus
        return response()->json([
            'status' => true , 
            'message' => 'Sukses delete data'
        ]) ;
    }
}
