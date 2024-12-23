<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licenses = License::all();
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $licence = new License();
        $licence->email = $request->email;
        $licence->password = $request->password;
        $licence->machine_code = $request->machine_code;
        $licence->name = $request->name;
        $licence->surname = $request->surname;
        $licence->start_date = $request->start_date;
        $licence->end_date = $request->end_date;
        $licence->license_type = $request->license_type;
        $licence->status = $request->status;
        $licence->credits_enable = $request->credits_enable;
        $licence->credit = $request->credit;
        $licence->addition_status = $request->addition_status;
        $licence->confirmed = $request->confirmed;
        $licence->confirmed_code = $request->confirmed_code;
        $licence->created_at = $request->created_at;
        $licence->updated_at = $request->updated_at;

        $licence->save();
        return response()->json(['message' => 'Ekleme başarılı']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licence = find($id);
        return $licence;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $licence = License::findOrFail($request->id);
        $licence->email = $request->email;
        $licence->password = $request->password;
        $licence->machine_code = $request->machine_code;
        $licence->name = $request->name;
        $licence->surname = $request->surname;
        $licence->start_date = $request->start_date;
        $licence->end_date = $request->end_date;
        $licence->license_type = $request->license_type;
        $licence->status = $request->status;
        $licence->credits_enable = $request->credits_enable;
        $licence->credit = $request->credit;
        $licence->addition_status = $request->addition_status;
        $licence->confirmed = $request->confirmed;
        $licence->confirmed_code = $request->confirmed_code;
        $licence->created_at = $request->created_at;
        $licence->updated_at = $request->updated_at;

        $licence->save();
        return response()->json(['message' => 'Güncelleme başarılı']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $licence = Item::destroy($id);
        return response()->json(['message' => 'Silme başarılı']);
    }
}
