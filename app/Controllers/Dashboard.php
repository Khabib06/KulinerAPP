<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use App\Models\ReviewModel;
use App\Models\UserModel;
use App\Models\PaymentModel;

class Dashboard extends BaseController
{
    public function index()
{
    if (session()->get('role') != 'admin') {
        return redirect()->to('/');
    }

    $placeModel = new PlaceModel();
    $reviewModel = new ReviewModel();
    $userModel = new UserModel();
    $paymentModel = new PaymentModel();

    $payments = $paymentModel
        ->select('payments.*, places.nama_tempat')
        ->join('places', 'places.id = payments.place_id')
        ->orderBy('payments.created_at', 'DESC')
        ->findAll();

    $totalIncome = $paymentModel
        ->selectSum('amount')
        ->where('status', 'paid')
        ->first();

    $data = [
        'total_place' => $placeModel->countAll(),
        'total_review' => $reviewModel->countAll(),
        'total_user' => $userModel->countAll(),
        'pending_place' => $placeModel->where('status', 'pending')->countAllResults(),

        'payments' => $payments,
        'total_income' => $totalIncome['amount'] ?? 0
    ];

    return view('dashboard', $data);
}
}