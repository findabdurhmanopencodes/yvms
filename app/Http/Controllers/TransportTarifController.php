<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransportTarifRequest;
use App\Http\Requests\UpdateTransportTarifRequest;
use App\Models\TransportTarif;
use Illuminate\Http\Request;

class TransportTarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        // $this->authorizeResource(Payroll::class,'Payroll');

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(TransportTarif::select())->make(true);
        }
       $tarifs =TransportTarif::orderBy('id', 'desc')->Paginate(10);

        return view('transportTarif.index', compact('tarifs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

          return view('transportTarif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransportTarifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportTarifRequest $request)
    {
        //$request->validate(['name' => 'required|string|unique:payment_types,name']);
        $request->validate(['price' => 'required|numeric|min:0:transport_tarifs,price']);

        TransportTarif::create([

            'price' => $request->get('price'),
          //  'km'=>$request->get('km')
        ]);

      return redirect()->route('transportTarif.index')->with('message', ' Transport tarif per km  created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function show(TransportTarif $transportTarif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function edit(TransportTarif $id)
    {
        $transportTarifs = TransportTarif::find($id);
        return view('transportTarif.edit', compact('transportTarifs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransportTarifRequest  $request
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransportTarifRequest $request, TransportTarif $id)

    {

        $transportTarif =TransportTarif::find($id);
        $transportTarif->price = $request->get('price');


        $data =  $request->validate(['price' => 'required|numeric|min:0:transport_tarifs,price']);

      //  $transportTarif->update($data);
        $transportTarif->save($data);

        return redirect()->route('transportTarif.edit')->with('message', 'TransportTarif updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,TransportTarif $transportTarif)
    {
        $transportTarif->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
