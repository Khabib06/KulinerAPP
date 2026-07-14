<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\PlaceModel;
use App\Libraries\Whatsapp;

class PaymentController extends BaseController
{
    protected $paymentModel;
    protected $placeModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->placeModel = new PlaceModel();

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function pay($place_id) 
    {
        $place = $this->placeModel->find($place_id);

        if (!$place) {
            return redirect()->to('/')->with('error', 'Tempat tidak ditemukan');
        }

        $orderId = 'PROMO-' . time() . '-' . random_int(1000, 9999);

        $amount = 30000;

        $this->paymentModel->insert([
            'place_id'      => $place_id,
            'order_id'      => $orderId,
            'package_name'  => 'Premium',
            'amount'        => $amount,
            'status'        => 'pending'
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount
            ],
            'item_details' => [[
                'id' => $place_id,
                'price' => $amount,
                'quantity' => 1,
                'name' => 'Promosi Tempat Kuliner'
            ]],
            'customer_details' => [
                'first_name' => session()->get('username') ?? 'Guest'
            ],
            'callbacks' => [
                'finish' => base_url('/'),
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params); //membuat transaksi midtrans

        return view('payment', [
            'snapToken' => $snapToken,
            'place' => $place
        ]);
    }

    public function notification()
{
    $json = file_get_contents("php://input");
    $notification = json_decode($json);

    if (!$notification) {
        return $this->response->setStatusCode(400)
            ->setJSON(['message' => 'Invalid notification']);
    }

    $orderId = $notification->order_id;
    $transactionStatus = $notification->transaction_status;

    $payment = $this->paymentModel
        ->where('order_id', $orderId)
        ->first();

    if (!$payment) {
        return $this->response->setStatusCode(404)
            ->setJSON(['message' => 'Payment not found']);
    }

    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {

        $this->paymentModel->update($payment['id'], [
            'status' => 'paid'
        ]);

        $this->placeModel->update($payment['place_id'], [
            'is_promoted' => 1,
            'promotion_package' => $payment['package_name'],
            'promotion_price' => $payment['amount'],
            'promotion_status' => 'active',
            'promotion_end' => date('Y-m-d H:i:s', strtotime('+30 days'))
        ]);

    } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel') {

        $this->paymentModel->update($payment['id'], [
            'status' => 'failed'
        ]);
    }

    return $this->response->setJSON([
        'message' => 'OK'
    ]);
    }

    public function success()
{
    $json = $this->request->getJSON(true);

    $orderId = $json['order_id'];

    $payment = $this->paymentModel
        ->where('order_id', $orderId)
        ->first();

    if (!$payment) {
        return $this->response->setJSON([
            'status' => 'error'
        ]);
    }

    $this->paymentModel->update($payment['id'], [
        'status' => 'paid'
    ]);

    $this->placeModel->update($payment['place_id'], [       //mengubah status pembayaran menjadi paid atau berhasil
        'is_promoted' => 1,
        'promotion_package' => $payment['package_name'],
        'promotion_price' => $payment['amount'],
        'promotion_status' => 'active',
        'promotion_end' => date('Y-m-d H:i:s', strtotime('+30 days'))
    ]);
    $place = $this->placeModel->find($payment['place_id']);

        $wa = new Whatsapp();

        $pesan =
        "🎉 PEMBAYARAN BERHASIL\n\n" .
        "Tempat : " . $place['nama_tempat'] . "\n" .
        "Paket : " . $payment['package_name'] . "\n" .
        "Nominal : Rp" . number_format($payment['amount'],0,',','.') . "\n\n" .
        "✅ Promosi telah aktif selama 30 hari.\n\n" .
        "Terima kasih telah menggunakan Kuliner Kampus UDINUS.";

        $wa->sendmassage(
            '6285121357710',
            $pesan
        );

    return $this->response->setJSON([
        'status' => 'success'
    ]);
}
    public function delete($id)
{
    if (session()->get('role') != 'admin') {
        return redirect()->to('/');
    }

    $payment = $this->paymentModel->find($id);

    if (!$payment) {
        return redirect()->back();
    }

    if ($payment['status'] == 'paid') {
        return redirect()->back()->with('error', 'Pembayaran yang sudah berhasil tidak bisa dihapus.');
    }

    $this->paymentModel->delete($id);

    return redirect()->to('/dashboard')
        ->with('success', 'Riwayat pembayaran berhasil dihapus.');
}
}
