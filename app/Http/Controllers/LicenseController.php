<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCreditRequest;
use App\Http\Requests\CreateLicenseRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateLicenseRequest;
use App\Mail\EmailConfirm;
use App\Mail\ForgotPasswordEmail;
use App\Models\License;
use App\Models\Userlog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CheckRequest;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    public function updateCredit(UpdateCreditRequest $request)
    {
        $license = License::where('machine_code', $request->MachineCode)->first();
        if (!$license) {
            return responder()->error(404, "Makine Kodu bulunamadı")->respond(404);
        }
        $data = json_decode($this->decrypt($request->Data, $request->MachineCode));
        if (!$data) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->status) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->confirmed) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->credits_enable && $license->end_date < Carbon::now()) {
            return responder()->error(401, "Lisansınız süreniz dolmuştur")->respond(401);
        }
        if ($license->credits_enable && $license->credit <= 0) {
            return responder()->error(401, "Kontörünüz kalmamıştır")->respond(401);
        }
        $license->credit -= (int) $data->UsedCredit;
        $license->save();
        $ret = [
            'Name'           => $license->name,
            'Surname'        => $license->surname,
            'StartDate'      => $license->start_date,
            'EndDate'        => $license->end_date,
            'LicenseType'    => $license->license_type,
            'AdditionStatus' => $license->addition_status,
            'CreditsEnable'  => $license->credits_enable,
            'Credit'         => $license->credit,
            'ReamingDay'     => Carbon::now()->diffInDays($license->end_date),
        ];
        $ret = [
            'license' => $this->encrypt(json_encode($ret), $request->MachineCode),
        ];
        return $ret;
    }
    

    public function check(CheckRequest $request)
    {
        $license = License::where('machine_code', $request->MachineCode)->first();
        if (!$license) {
            return responder()->error(404, "Makine Kodu bulunamadı")->respond(404);
        }
        $data = json_decode($this->decrypt($request->Data, $request->MachineCode));
        if (!$data) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if ($license->email !== $data->Email) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->status) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->confirmed) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->credits_enable && $license->end_date < Carbon::now()) {
            return responder()->error(401, "Lisansınız süreniz dolmuştur")->respond(401);
        }
        if ($license->credits_enable && $license->credit <= 0) {
            return responder()->error(401, "Kontörünüz kalmamıştır")->respond(401);
        }
        $ret = [
            'Name'           => $license->name,
            'Surname'        => $license->surname,
            'StartDate'      => $license->start_date,
            'EndDate'        => $license->end_date,
            'LicenseType'    => $license->license_type,
            'AdditionStatus' => $license->addition_status,
            'CreditsEnable'  => $license->credits_enable,
            'Credit'         => $license->credit,
            'CreatedAt'      => $license->created_at,
            'ReamingDay'     => Carbon::now()->diffInDays($license->end_date),
        ];
        $ret = [
            'license' => $this->encrypt(json_encode($ret), $request->MachineCode),
        ];
        return $ret;
    }

    public function login(LoginRequest $request)
    {
        $license = License::where('machine_code', $request->MachineCode)->first();
        if (!$license) {
            return responder()->error(404, "Makine Kodu bulunamadı")->respond(404);
        }
        $data = json_decode($this->decrypt($request->Data, $request->MachineCode));
        if (!$data) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if ($license->email !== $data->Email || !app('hash')->check($data->Password, $license->password)) {
            return responder()->error(403, "Kullanıcı adı yada Şifre hatalı")->respond(403);
        }
        if (!$license->status) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->confirmed) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }
        if (!$license->credits_enable && $license->end_date < Carbon::now()) {
            return responder()->error(401, "Lisansınız süreniz dolmuştur")->respond(401);
        }
        if ($license->credits_enable && $license->credit <= 0) {
            return responder()->error(401, "Kontörünüz kalmamıştır")->respond(401);
        }
        $ret = [
            'Name'           => $license->name,
            'Surname'        => $license->surname,
            'StartDate'      => $license->start_date,
            'EndDate'        => $license->end_date,
            'LicenseType'    => $license->license_type,
            'AdditionStatus' => $license->addition_status,
            'CreditsEnable'  => $license->credits_enable,
            'Credit'         => $license->credit,
            'CreatedAt'      => $license->created_at,
            'ReamingDay'     => Carbon::now()->diffInDays($license->end_date),
        ];
        $ret = [
            'license' => $this->encrypt(json_encode($ret), $request->MachineCode),
        ];
        
        if(DB::table('userlog')->where('email', '=', $data->Email)->exists()){
        DB:: table("userlog")->where("email",$data->Email)->update([
        "login_time"=>Carbon::now()->toDate()
        ]);
        }
    else {
        DB::table("userlog")->insert([
            "email"=>$data->Email,
            "login_time"=>Carbon::now()->toDate()
        ]); 
        }
    
       
        return $ret;
         
    }
    public function register(RegisterRequest $request)
    {
        $license = License::where('machine_code', $request->MachineCode)->first();
        if ($license) {
            return responder()->error(401, "Kullanıcı sistemde zaten mevcut")->respond(401);
        }
        $data = json_decode($this->decrypt($request->Data, $request->MachineCode));
        if (!$data) {
            return responder()->error(403)->respond(403);
        }

        $license = License::where('email', $data->Email)->first();
        if ($license) {
            return responder()->error(401, "Kullanıcı sistemde zaten mevcut")->respond(401);
        }

        if (!$data->Password) {
            return responder()->error(403)->respond(403);
        }

        $license = License::create([
            'email'           => $data->Email,
            'password'        => app('hash')->make($data->Password),
            'machine_code'    => $request->MachineCode,
            'name'            => $data->Name,
            'surname'         => $data->Surname,
            'start_date'      => Carbon::now()->toDate(),
            'end_date'        => Carbon::now()->addDay(1)->toDate(),
            'license_type'    => 'demo',
            'addition_status' => 0,
            'credits_enable'  => 1,
            'credit'          => 50,
            'status'          => true,
            'confirmed'       => false,
            'confirm_code'    => random_int(100000, 999999),
        ]);

        Mail::to($license->email)
            ->bcc('erd5334@gmail.com')
            ->send(new EmailConfirm($license));

        return responder()->success()->respond(201);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $license = License::where('machine_code', $request->MachineCode)->first();
        if (!$license) {
            return responder()->error(404, "Makine Kodu bulunamadı")->respond(404);
        }

        $data = json_decode($this->decrypt($request->Data, $request->MachineCode));
        if (!$data || !$data->Email) {
            return responder()->error(403, "Lisansınız geçerli değil")->respond(403);
        }

        if ($license->email !== $data->Email) {
            return responder()->error(403, "Kullanıcı adı hatalı")->respond(403);
        }

        $new_password = $this->random_str(8);

        $license->password = app('hash')->make($new_password);
        $license->save();
        Mail::to($license->email)
            ->bcc('erd5334@gmail.com')
            ->send(new ForgotPasswordEmail($license, $new_password));

        return responder()->success()->respond(204);
    }

    public function getLicenses()
    {
        return responder()->success(License::all())->respond();
    }
    public function getUserlog()
    {
        return responder()->success(Userlog::all())->respond();
    }

    public function getLicenseById($id)
    {
        $license = License::find($id);
        if (!$license) {
            return responder()->error(404)->respond(404);
        }
        return responder()->success($license)->respond();
    }

    public function getLicenseByMachineCode($code)
    {
        $license = License::where('machine_code', $code);
        if (!$license) {
            return responder()->error(404)->respond(404);
        }
        return responder()->success($license)->respond();
    }

    public function createLicense(CreateLicenseRequest $request)
    {
        License::create($request->validated());
        return responder()->success()->respond(201);
    }

    public function updateLicense($id, UpdateLicenseRequest $request)
    {
        $license = License::find($id);
        if (!$license) {
            return responder()->error(404)->respond(404);
        }
        $license->update($request->validated());
        return responder()->success($license)->respond();
    }

    public function destroyLicense($id)
    {
        $license = License::find($id);
        if (!$license) {
            return responder()->error(404)->respond(404);
        }
        $license->delete();
        return responder()->success()->respond(204);
    }

    public function changePasswordLicense(Request $request)
    {
        $this->validate($request, [
            'id'       => 'integer|required',
            'password' => 'string|required',
        ]);

        $license = License::find($request->id);
        if (!$license) {
            return responder()->error(404)->respond(404);
        }
        $license->password = app('hash')->make($request->password);
        $license->save();

        return responder()->success()->respond(204);
    }

    public function emailConfirm(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'code'  => 'integer|required',
        ]);

        $license = License::where('email', $request->email)->first();
        if (!$license) {
            return responder()->error(404, "Bulunamadı")->respond(404);
        }

        if ((int) $license->confirm_code !== (int) $request->code) {
            return responder()->error(404, "Bulunamadı")->respond(404);
        }

        $license->confirmed = true;
        $license->save();
        return "E-Posta adresiniz başarı ile doğrulandı.";
    }

    private function encrypt($data, $secret)
    {
        $method   = 'aes-256-cbc';
        $password = substr(hash('sha256', $secret, true), 0, 32);
        $iv       = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return base64_encode(openssl_encrypt($data, $method, $password, OPENSSL_RAW_DATA, $iv));
    }

    private function decrypt($data, $secret)
    {
        $method   = 'aes-256-cbc';
        $password = substr(hash('sha256', $secret, true), 0, 32);
        $iv       = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        return openssl_decrypt(base64_decode($data), $method, $password, OPENSSL_RAW_DATA, $iv);
    }

    private function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max    = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}
