<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use App\Models\CategoryModel;
use App\Libraries\Whatsapp;

class PlaceController extends BaseController
{
    public function create()
    {
        if (!session()->get('logged_in')) { //validasi user
            return redirect()->to('/login');
        }

        $categoryModel = new CategoryModel();

        $data['categories'] = $categoryModel->findAll();

        return view('create_place', $data);
    }

    public function store()     
{
$placeModel = new PlaceModel();

$file = $this->request->getFile('foto');

if ($file && $file->isValid() && !$file->hasMoved()) {
    $newName = $file->getRandomName();
    $file->move('uploads', $newName);
} else {
    $newName = 'default.jpg';
}

$namaTempat = $this->request->getPost('nama_tempat');

$isPromoted = $this->request->getPost('is_promoted') ? 1 : 0;

$package = $this->request->getPost('promotion_package');

$price = $this->request->getPost('promotion_price');

$statusPromotion = $isPromoted ? 'pending' : 'none';

$placeModel->save([

    'category_id' => $this->request->getPost('category_id'),
    'nama_tempat' => $namaTempat,
    'alamat' => $this->request->getPost('alamat'),
    'deskripsi' => $this->request->getPost('deskripsi'),

    'latitude' => $this->request->getPost('latitude'),
    'longitude' => $this->request->getPost('longitude'),

    'foto' => $newName,
    'status' => 'pending',

    'is_promoted' => $isPromoted,
    'promotion_package' => $package,
    'promotion_price' => $price,
    'promotion_status' => $statusPromotion

]);

$wa = new Whatsapp();           //Mengirim notifikasi ketika user menambahkan tempat baru.
$wa->sendmassage(
    '6285121357710',
    '📍 Tempat baru ditambahkan: ' . $namaTempat . '. Menunggu approval admin.'
);

return redirect()->to('/')->with('success', 'Tempat berhasil ditambahkan');


}


    public function edit($id)
    {
        $placeModel = new PlaceModel();
        $categoryModel = new CategoryModel();

        $data['place'] = $placeModel->find($id);
        $data['categories'] = $categoryModel->findAll();

        return view('edit_place', $data);
    }

    public function update($id) 
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $placeModel = new PlaceModel();

        $placeModel->update($id, [
        'category_id' => $this->request->getPost('category_id'),
        'nama_tempat' => $this->request->getPost('nama_tempat'),
        'alamat' => $this->request->getPost('alamat'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'latitude' => $this->request->getPost('latitude'),
        'longitude' => $this->request->getPost('longitude')
    ]);

        return redirect()->to('/')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
{
    if (session()->get('role') != 'admin') {
        return redirect()->to('/');
    }

    $placeModel = new PlaceModel();

    $place = $placeModel->find($id);

    if (!$place) {
        return redirect()->back()
            ->with('error','Data tidak ditemukan');
    }

    // hapus foto jika bukan default
    if (!empty($place['foto']) && $place['foto'] != 'default.jpg') {

        $path = FCPATH . 'uploads/' . $place['foto'];

        if (file_exists($path)) {
            unlink($path);
        }

    }

    $placeModel->delete($id);

    return redirect()->to('/pending-places')
        ->with('success','Tempat berhasil dihapus.');
}

    public function approve($id)
{
if (session()->get('role') != 'admin') {
return redirect()->to('/pending-places');
}


$placeModel = new PlaceModel();

$placeModel->update($id, [
    'status' => 'approved'
]);

$place = $placeModel->find($id);

$wa = new Whatsapp();               //Mengirim notifikasi ketika admin menyetujui tempat kuliner.
$wa->sendmassage(
    '6285121357710',
    '✅ Tempat "' . $place['nama_tempat'] . '" telah di-approve admin.'
);

return redirect()->to('/pending-places')
    ->with('success', 'Tempat berhasil di-approve');


}


    public function pending()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $placeModel = new PlaceModel();

        $data['places'] = $placeModel
            ->where('status', 'pending')
            ->findAll();

        return view('pending_places', $data);
    }

    public function review($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $reviewModel = new \App\Models\ReviewModel();
        
        // role user
        $reviewModel->save([
            'user_id' => session()->get('user_id'),
            'place_id' => $id,
            'rating' => $this->request->getPost('rating'),
            'komentar' => $this->request->getPost('komentar')
        ]); 
        $wa = new Whatsapp();           //Mengirim notifikasi ketika user memberikan review.
$wa->sendmassage(
'6285121357710',
'⭐ Review baru untuk Place ID ' . $id .
' | Rating: ' . $this->request->getPost('rating') .
' | Komentar: ' . $this->request->getPost('komentar')
);

        return redirect()->to('/')->with('success', 'Review berhasil ditambahkan');
    }

   
}