<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Periode;
use Alert;
use Help;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = Periode::all();
        return view('root.periode.index',compact('periode'));
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
        $data = $request->all();
        if (Periode::where('periode','=',$data['periode'])->count() == 0) {
          $title = $request->input('title');
          $conf = $request->input('config');
          $config  = [];
          foreach ($title as $key => $value) {
            $config[$value] = $conf[$key];
          }
          $periode = Periode::create([
            'periode' => $data['periode'],
            'config' => json_encode($config)
          ]);
          Alert::new('success','Periode berhasil dibuat.');
        }else {
          Alert::new('danger','Periode sudah digunakan');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return view('root.periode.edit',compact('periode'));
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
        $title = $request->input('title');
        $value = $request->input('config');
        $config  = [];
        foreach ($title as $key => $row) {
          $config[$row] = $value[$key];
        }
        Periode::find($id)->update([
          'periode' => $request->periode,
          'config' => json_encode($config)
        ]);
        Alert::new('success','Berhasil menyimpan pembaruan periode.');
        return redirect(Help::url('periode'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
