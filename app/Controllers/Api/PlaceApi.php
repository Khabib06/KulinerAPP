<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PlaceModel;

class PlaceApi extends BaseController
{
    public function index()
    {
        $placeModel = new PlaceModel();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data tempat kuliner',
            'data' => $placeModel
                ->where('status', 'approved')
                ->findAll()
        ]);                                         //Mengambil seluruh data kuliner dari database
    }

    public function detail($id)
    {
        $placeModel = new PlaceModel();

        $place = $placeModel->find($id);

        if (!$place) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $place
        ]);
    }

    public function create()
    {
        $placeModel = new PlaceModel();

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'nama_tempat' => $this->request->getPost('nama_tempat'),
            'alamat' => $this->request->getPost('alamat'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'status' => 'pending'
        ];

        $placeModel->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }
}