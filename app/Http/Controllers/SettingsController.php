<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateDuyuruRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Http\Requests\UpdateWhatsappRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getSettings(Request $request)
    {
        return json_decode(file_get_contents(storage_path("settings.json")), true, 512, JSON_THROW_ON_ERROR);
    }
	public function kutuphane(Request $request)
    {
        return json_decode(file_get_contents(storage_path("kutuphane.json")), true, 512, JSON_THROW_ON_ERROR);
    }
     public function getSettings2(Request $request)
    {
        return json_decode(file_get_contents(storage_path("settings2.json")), true, 512, JSON_THROW_ON_ERROR);
    }		
    public function getNews(Request $request)
    {
        return json_decode(file_get_contents(storage_path("News.json")), true, 512, JSON_THROW_ON_ERROR);
    }
      public function getYoutube(Request $request)
    {
        return json_decode(file_get_contents(storage_path("Youtube.json")), true, 512, JSON_THROW_ON_ERROR);
    }
        public function sozler(Request $request)
    {
        return json_decode(file_get_contents(storage_path("sozler.json")), true, 512, JSON_THROW_ON_ERROR);
    }
        public function updateDuyuru(updateDuyuruRequest $request)
{
    $duyuru = json_decode(file_get_contents(storage_path('settings.json')), true, 512, JSON_THROW_ON_ERROR);

    $duyuru["Duyuru"]["YeniDuyuru"] = $request->input('YeniDuyuru');
    $duyuru["Duyuru"]["BirAyet"] = $request->input('BirAyet');
    $duyuru["Duyuru"]["BirHadis"] = $request->input('BirHadis');
    $duyuru["Duyuru"]["GununSozu"] = $request->input('GununSozu');

    $updatedJson = json_encode($duyuru, JSON_UNESCAPED_UNICODE  | JSON_PRETTY_PRINT);
    file_put_contents(storage_path('settings.json'), $updatedJson, LOCK_EX);

    return response()->json(['message' => 'Duyuru başarıyla güncellendi.'],JSON_UNESCAPED_UNICODE);
 
}
    public function updateSms(UpdateSmsRequest $request)
{
    $sms = json_decode(file_get_contents(storage_path('settings.json')), true, 512, JSON_THROW_ON_ERROR);
    $sms["Sms"]["SmsAyar1"] = $request->input('SmsAyar1');
    $sms["Sms"]["SmsAyar2"] = $request->input('SmsAyar2');
    $sms["Sms"]["SmsAyar3"] = $request->input('SmsAyar3');

    $updatedJson = json_encode($sms, JSON_UNESCAPED_UNICODE  | JSON_PRETTY_PRINT);
    file_put_contents(storage_path('settings.json'), $updatedJson, LOCK_EX);

    return response()->json(['message' => 'Duyuru başarıyla güncellendi.'],JSON_UNESCAPED_UNICODE);
 
}

public function updateWhatsapp(UpdateWhatsappRequest $request)
{
    $whatsapp = json_decode(file_get_contents(storage_path('settings.json')), true, 512, JSON_THROW_ON_ERROR);

    $whatsapp["Whatsapp"]["WhatsappAyar1"] = $request->input('WhatsappAyar1');
    $whatsapp["Whatsapp"]["WhatsappAyar2"] = $request->input('WhatsappAyar2');
    $whatsapp["Whatsapp"]["WhatsappAyar3"] = $request->input('WhatsappAyar3');
    $whatsapp["Whatsapp"]["WhatsappAyar4"] = $request->input('WhatsappAyar4');
    $whatsapp["Whatsapp"]["WhatsappAyar5"] = $request->input('WhatsappAyar5');
    $whatsapp["Whatsapp"]["WhatsappAyar6"] = $request->input('WhatsappAyar6');
    $whatsapp["Whatsapp"]["WhatsappAyar7"] = $request->input('WhatsappAyar7');
    $whatsapp["Whatsapp"]["WhatsappAyar8"] = $request->input('WhatsappAyar8');
    $whatsapp["Whatsapp"]["WhatsappAyar9"] = $request->input('WhatsappAyar9');
    $whatsapp["Whatsapp"]["WhatsappAyar10"] = $request->input('WhatsappAyar10');
    $whatsapp["Whatsapp"]["WhatsappAyar11"] = $request->input('WhatsappAyar11');
    $whatsapp["Whatsapp"]["WhatsappAyar12"] = $request->input('WhatsappAyar12');
    $whatsapp["Whatsapp"]["WhatsappAyar13"] = $request->input('WhatsappAyar13');
    $whatsapp["Whatsapp"]["WhatsappAyar14"] = $request->input('WhatsappAyar14');
    $whatsapp["Whatsapp"]["WhatsappAyar15"] = $request->input('WhatsappAyar15');
    

    $updatedJson = json_encode($whatsapp, JSON_UNESCAPED_UNICODE  | JSON_PRETTY_PRINT);
    file_put_contents(storage_path('settings.json'), $updatedJson, LOCK_EX);

    return response()->json(['message' => 'Duyuru başarıyla güncellendi.'],JSON_UNESCAPED_UNICODE);
 
}

    private function encrypt($data, $secret)
    {
        $method   = 'aes-256-cbc';
        $password = substr(hash('sha256', $secret, true), 0, 32);
        $iv       = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return base64_encode(openssl_encrypt($data, $method, $password, OPENSSL_RAW_DATA, $iv));
    }
}
