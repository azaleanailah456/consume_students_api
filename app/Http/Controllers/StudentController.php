<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {
        // mengambil data dari input search
        $search = $request->search;

        // memanggil file BaseApi dari class BaseApi, new : karna BaseApi bentuknya class
        // memanggil libraries BaseApi method nya index dengan mengirim parameter1 berupa path data dari parameter2 data untuk mengisi search_nama API nya
        $data = (new BaseApi)->index('/api/students', ['search_nama' => $search]);

        // ambil response jsonya
        $students = $data->json();
        // dd($students);

        // kirim hasil pengambilan data ke blade index
        return view('index')->with(['students' => $students['data']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];

        $proses = (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil menambahkan data baru ke students API');
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
    public function edit($id)
    {
        // proses ambil data api ke route REST API /students/{id}
        // .$id karna buat nyabungin string sama variable
        $data = (new BaseApi)->edit('/api/students/'.$id);        
        if ($data->failed()) {
            // kaau gagal proses $data diatas, ambil deskripsi err dari json property data
            $student = $data->json('data');
            // baikan ke halaman awal, sama errors nya
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // kalau berhasi, ambil data dari jsonya
            $student = $data->json('data');
            // alihin ke blade edit dengan mengirim data $student diatas agar bisa digunakan pada blade
            return view('edit')->with(['student' => $student]);
        }
    } 

    /**
     * Update the specified resource in storage.
     */

     // Request $request untuk memanggil data dari inputan form yg di buat di blade
    public function update(Request $request, $id)
    {
        // data yang akan dikirim ($request ke REST API)
        $payload = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];

        // panggil method dari BaseApi, kirim endpoint(route update dari REST APInya) dan data ($payload diatas)
        // .$id, $payload = titik buat nyambungin ke endpoint, koma buat pisahin 
        $proses = (new BaseApi)->update('/api/students/update/'.$id, $payload);
        if ($proses->failed()) {
            //kalau gagal, balikin lagi sama pesan errors dari jsonya
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // berhassil, balikin ke halaman paing awa dengan pesan
            return redirect('/')->with('success', 'Berhasil mengubah data siswa dari API');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/'.$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil hapus data sementara dari API');
        }
    }

    public function trash()
    {
        $proses = (new BaseApi)->trash('/api/students/show/trash');
        // dd($proses);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            $studentTrash = $proses->json('data');
            return view('trash')->with(['studentsTrash' => $studentTrash]);
        }
    }

    public function permanent($id)
    {
        $proses = (new BaseApi)->permanent('/api/students/trash/delete/permanent/'. $id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil menghapus data secara permanent!');
        }
    }

    public function restore($id)
    {
        $proses = (new BaseApi)->restore('/api/students/trash/restore/'.$id);
        // dd($proses);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil mengembalikan data dari sampah!');
        }
    }
}
