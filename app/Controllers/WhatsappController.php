<?php

namespace App\Controllers;

Use App\Libraries\Whatsapp;

Class WhatsappController extends BaseController
{
    public function index(): string
    {
        return view('whatsapp/from');
    }

    public function send($nomor = null, $pesan = null)
{
    if ($nomor && $pesan) {

        $wa = new \App\Libraries\Whatsapp();

        $result = $wa->sendmassage($nomor, $pesan);

        return $this->response->setJSON($result);
    }

    return "parameter kosong";
}
}