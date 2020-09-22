<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
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

    public function getByIdUser( $type, $id )
    {
        $response = null;
        try{
            $paymentMethod = PaymentMethod::resolve( $type );
            $response = response()->json( $paymentMethod->newQuery()->where( 'id_user', $id )->firstOrFail(['card_number', 'name_on_card', 'expire_at_month', 'expire_at_year' ])->toArray() );
        }
        catch ( \Exception $e ){
            $response = response()->json(['ok' => false, 'message' => $e->getMessage() ], 421 );
        }

        return $response;
    }
}
