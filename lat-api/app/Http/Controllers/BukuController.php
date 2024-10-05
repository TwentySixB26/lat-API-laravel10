<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //untuk mendapatkan client,!!! WAJIB ADA !!! 
        $client = new Client() ; 

        //url agar dapat terhubung ke api 
        $url = "http://127.0.0.1:8000/api/buku" ;
        
        //menghubungkan client kepada API mengunakan url 
        $response = $client->request('GET' , $url) ;


        //mengambil isi data dari respons HTTP dan masih dalam bentuk json
        $content =  $response->getBody()->getContents() ;
        
        // mendecode string JSON menjadi array PHP
        $contentArray = json_decode($content,true) ;      
        
        // mengakses nilai tertentu dari array tersebut (dalam hal ini, elemen yang bernama 'data'). didalam $contentArray terdapat beberapa isi salah satunya 'data'
        $data = $contentArray['data'] ;        


        return view('buku/index',['data' => $data]) ; 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // mengambil parameter atau isi dari form input 
        $judul = $request->judul ; 
        $pengarang = $request->pengarang ; 
        $tanggal_publikasi = $request->tanggal_publikasi ; 

        // menjadikan semua yang telah ditangkap oleh input menjadi array
        $parameter = [
            'judul' => $judul ,
            'pengarang' => $pengarang,
            'tanggal_publikasi' => $tanggal_publikasi
        ] ;

        //untuk mendapatkan client 
        $client = new Client() ; 

        //url agar dapat terhubung ke api 
        $url = "http://127.0.0.1:8000/api/buku" ; 

        //mengirimkan data mengunakan POST melalui $url dan dikirim ke 'headers' beserta 'body'
        $response = $client->request('POST' , $url,[
            'headers' => ['Content-type' =>'application/json'] ,
            'body' => json_encode($parameter)   //dilakukan encode agar data berubah menjadi json bukan array
        ]) ;

        //mengambil isi data dari respons HTTP dan masih dalam bentuk json
        $content =  $response->getBody()->getContents() ;       

        // mendecode string JSON menjadi array PHP
        $contentArray = json_decode($content,true) ;     

        

        // return view('buku/index',['data' => $data]) ;
        // print_r($data) ; 

        //jika data gagal maka statusnya akan false maka akan menjalankan fungsi ini
        if($contentArray['status']!= true){
            //mengambil/mengangkap isi data 
            $error = $contentArray['data'] ;    

            //melakukan redirect ke '/buku', withErrors akan mengirimkan error ke halaman yang dilakukan redirect begitu juga dengan withInput  
            return redirect('/buku')->withErrors($error)->withInput() ; 
        }else {
            //pesan ketika success
            return redirect('/buku')->with('success', 'berhasil memasukan data') ; 
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //untuk mendapatkan client 
        $client = new Client() ; 

        //url agar dapat terhubung ke api 
        $url = "http://127.0.0.1:8000/api/buku/$id" ;
        
        //menghubungkan client kepada API mengunakan url 
        $response = $client->request('GET' , $url) ;


        //mengambil isi data dari respons HTTP dan masih dalam bentuk json
        $content =  $response->getBody()->getContents() ;
        
        // mendecode string JSON menjadi array PHP
        $contentArray = json_decode($content,true) ;      
        
        //jika tidak ada id tertentu maka statusnya akan bernilai false dan mengembalikan message berupa error
        if ($contentArray['status'] == false) {
            $error= $contentArray['message'] ; 
            return redirect('/buku')->withErrors($error) ; 
        } else {
            $data = $contentArray['data'] ; 
            return view('/buku/index', ['data' => $data]) ; 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // mengambil parameter atau isi dari form input 
        $judul = $request->judul ; 
        $pengarang = $request->pengarang ; 
        $tanggal_publikasi = $request->tanggal_publikasi ; 

        // menjadikan semua yang telah ditangkap oleh input menjadi array
        $parameter = [
            'judul' => $judul ,
            'pengarang' => $pengarang,
            'tanggal_publikasi' => $tanggal_publikasi
        ] ;

        //untuk mendapatkan client 
        $client = new Client() ; 

        //url agar dapat terhubung ke api 
        $url = "http://127.0.0.1:8000/api/buku/$id" ; 

        //mengirimkan data mengunakan POST melalui $url dan dikirim ke 'headers' beserta 'body'
        $response = $client->request('PUT' , $url,[
            'headers' => ['Content-type' =>'application/json'] ,
            'body' => json_encode($parameter)   //dilakukan encode agar data berubah menjadi json bukan array
        ]) ;

        //mengambil isi data dari respons HTTP dan masih dalam bentuk json
        $content =  $response->getBody()->getContents() ;       

        // mendecode string JSON menjadi array PHP
        $contentArray = json_decode($content,true) ;     


        //jika data gagal maka statusnya akan false maka akan menjalankan fungsi ini
        if($contentArray['status']!= true){
            //mengambil/mengangkap isi data 
            $error = $contentArray['data'] ;    

            //melakukan redirect ke '/buku', withErrors akan mengirimkan error ke halaman yang dilakukan redirect begitu juga dengan withInput  
            return redirect('/buku')->withErrors($error)->withInput() ; 
        }else {
            //pesan ketika success
            return redirect('/buku')->with('success', 'berhasil update data') ; 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client() ; 

        //url agar dapat terhubung ke api 
        $url = "http://127.0.0.1:8000/api/buku/$id" ; 

        //mengirimkan data mengunakan POST melalui $url dan dikirim ke 'headers' beserta 'body'
        $response = $client->request('DELETE' , $url,) ;

        //mengambil isi data dari respons HTTP dan masih dalam bentuk json
        $content =  $response->getBody()->getContents() ;       

        // mendecode string JSON menjadi array PHP
        $contentArray = json_decode($content,true) ;     


        //jika data gagal maka statusnya akan false maka akan menjalankan fungsi ini
        if($contentArray['status']!= true){
            //mengambil/mengangkap isi data 
            $error = $contentArray['data'] ;    

            //melakukan redirect ke '/buku', withErrors akan mengirimkan error ke halaman yang dilakukan redirect begitu juga dengan withInput  
            return redirect('/buku')->withErrors($error)->withInput() ; 
        }else {
            //pesan ketika success
            return redirect('/buku')->with('success', 'berhasil hapus  data') ; 
        }
    }
}
