<?php
// perbedaan helpers dan libraries
// Helpers = bikin API
// Libraries = pake API
namespace App\Http\Libraries;
// namespace = mengatur posisi file 

use Illuminate\Support\Facades\Http;

class BaseApi
{
    // variable yg cuman bisa di akses di class ini dan turunanya
    protected $baseUrl;
    // constractor : menyiapkan isi data, dijalankan otomatis tanpa dipanggil 
    public function __construct()
    {
        // var $baseUrl yg diatas diisinya nilainya dari isian file .env bagian API_HOST
        // var ini diisi otomatis ketikan files/class BaseApi dipanggil di controller
        $this->baseUrl = "http://127.0.0.1:2222";
    }
    
    private function client()
    {
        // koneksikan ip dari var $baseUrl ke depedency Http
        // menggunakan depedency Http karna projek API nya berbasis web (protocol Http)
        return Http::baseUrl($this->baseUrl);
    }

    public function index(String $endpoint, Array $data = [])
    {
        // manggil ke funnc client yg diatas, trs manggil path yg dai $endpoint  yg dikirim controllernya , kalau ada data yg mau di cari (params di postman) diambil dari parameter2 $data
        return $this->client()->get($endpoint, $data);
    }

    public function store(String $endpoint, Array $data= [])
    {
        // pake post() karena buat route tambah data di poject REST API nya pake ::post
        return $this->client()->post($endpoint, $data);
    }

    public function edit(String $endpoint, Array $data= [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function update(String $endpoint, Array $data= [])
    {
        return $this->client()->patch($endpoint, $data);
    }

    public function delete(String $endpoint, Array $data= [])
    {
        return $this->client()->delete($endpoint, $data);
    }

    public function trash(String $endpoint, Array $data= [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function restore(String $endpoint, Array $data= [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function permanent(String $endpoint, Array $data= [])
    {
        return $this->client()->get($endpoint, $data);
    }

}

?>