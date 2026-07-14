<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class Whatsapp
{
    public function sendmassage($nomor, $pesan)
    {
        if (str_starts_with($nomor, '+')) {
            $nomor = substr($nomor, 1);
        } elseif (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        $waUrl = getenv('wa_url');
        $waApi = getenv('waapi');

        $client = new Client([
            'base_uri' => $waUrl,
            'timeout'  => 30,
            'headers'  => [
                'Content-Type' => 'application/json',
                'X-Api-Key'    => $waApi,
            ],
        ]);

        try {

            $response = $client->post('/api/sendText', [
                'json' => [
                    'chatId' => $nomor . '@c.us',
                    'text' => $pesan,
                    'session' => 'default',
                ],
            ]);         //Bagian ini mengirim request ke WAHA API untuk mengirim pesan WhatsApp.

            return [
                'status' => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];

        } catch (\Exception $e) {

            return [
                'status' => 500,
                'error' => $e->getMessage(),
            ];

        }
    }
}