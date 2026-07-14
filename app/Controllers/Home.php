<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use App\Models\ReviewModel;

class Home extends BaseController
{
    public function index()
    {
        $placeModel = new PlaceModel();
        $reviewModel = new ReviewModel();

        $keyword = $this->request->getGet('keyword');

        // hanya tampilkan yang sudah approved
        $placeModel->where('status', 'approved');

        // fitur search
        if ($keyword) {
            $placeModel->like('nama_tempat', $keyword);
        }

        // promoted tampil paling atas
        $placeModel->orderBy('is_promoted', 'DESC');
        $placeModel->orderBy('created_at', 'DESC');

        $places = $placeModel->findAll();

        // ambil review tiap tempat
        foreach ($places as $key => $place) {
            $places[$key]['reviews'] = $reviewModel
                ->where('place_id', $place['id'])
                ->findAll();
        }

        return view('home', [
            'places' => $places
        ]);
    }
}