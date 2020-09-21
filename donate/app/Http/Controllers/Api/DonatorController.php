<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonatorRequest;
use App\Http\Resources\UserResource;
use App\Models\Donation;
use App\Models\User;
use App\Models\UserData;
use App\Service\Exception\PaymentMethodNotFoundException;
use App\Service\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index( Request $request )
    {
        return UserResource::collection( User::query()->where('status', 1 )->get()->all() );
        /*return response()->json([
            'donators' => [
                [ 'name' => 'Nome Doador', 'email' => 'email@doador.com' ],
                [ 'name' => 'Doador da Silva', 'email' => 'emaildo@doador.com' ],
            ]
        ]);*/
    }

    /**
     * Store a newly created donator in storage.
     *
     * @param  DonatorRequest $request
     * @return JsonResponse
     */
    public function store( DonatorRequest $request ): JsonResponse
    {
        try {

            $data = $request->post('donator' );

            $user = User::create([
                'name'  => $data['name'],
                'email' => $data['email'],
                'cpf'   => $data['cpf'],
                'dob'   => \DateTime::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d')
            ]);

            $userData = UserData::create([
                'id_user' => $user->id,
                'store' => [
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'phone_secondary' => $data['phone_secondary']
                ]
            ]);

            $donationData = $request->post('donation' );

            $donation = Donation::query()->create([
                'id_user' => $user->id,
                'frequency' => $donationData['frequency'],
                'amount' => \str_replace(',', '.', $donationData['amount'] )
            ]);

            $paymentMethod = PaymentMethod::resolve( $donationData['payment']['type'] );
            $paymentMethod->fill([
                'id_user' => $user->id,
                'name_on_card' => $donationData['payment']['name_on_card'],
                'card_number' => $donationData['payment']['card_number'],
                'expire_at_month' => $donationData['payment']['expire_at_month'],
                'expire_at_year' => $donationData['payment']['expire_at_year'],
            ]);
            $paymentMethod->save();
            $response = response()->json( [ 'ok' => true ] );
        }
        catch( PaymentMethodNotFoundException $e ){
            $response = response()->json( [ 'message' => $e->getMessage() ], 421 );
        }
        catch( \Exception $e ){
            $response = response()->json( [ 'message' => $e->getMessage() ], 422 );
        }

        return $response;
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
}
