<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title']          = 'Setting Aplikasi - PUDEMAS';
        $data['page']           = 'Setting Aplikasi';
        $data['setting']        = Setting::Setting()->get();

        return view('setting')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function updateSetting(Request $request)
    {
        try {
            $attributeNames             = array(
                'id_courier'            => 'ID Kurir',
                'lat_start'             => 'Default Latitude Toko',
                'lng_start'             => 'Default Longtitude Toko',
                'default_send_cost'     => 'Biaya Kirim Per KM',
                'default_watcher'       => 'Update Interval Pengawas',
                'default_courier'       => 'Update Interval Kurir',
            );

            $validator                  = Validator::make($request->all(), [
                'id_courier'            => 'required|numeric',
                'lat_start'             => 'required',
                'lng_start'             => 'required',
                'default_send_cost'     => 'required|numeric',
                'default_watcher'       => 'required|numeric',
                'default_courier'       => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            $setting                                = Setting::find(1);
            $setting->id_courier                    = $request->id_courier;
            $setting->lat_start                     = $request->lat_start;
            $setting->lng_start                     = $request->lng_start;
            $setting->default_send_cost             = $request->default_send_cost;
            $setting->watcher_view_update           = $request->default_watcher;
            $setting->courier_location_update       = $request->default_courier;
            $action                                 = $setting->save();

            return redirect()->back()->with('success', 'Data Berhasil Diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
