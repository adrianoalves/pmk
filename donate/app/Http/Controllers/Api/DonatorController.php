<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonatorRequest;
use App\Http\Resources\UserResource;
use App\Models\Donation;
use App\Models\Traits\Exceptions\EmptySearchParamException;
use App\Models\Traits\Exceptions\SearchParamNotFoundException;
use App\Models\User;
use App\Models\UserData;
use App\Service\Exception\PaymentMethodNotFoundException;
use App\Service\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DonatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index( Request $request )
    {
        try {
            $statement = User::prepareSearch( $request->all() );
            $response = UserResource::collection( $statement->where('status', 1 )->get()->all() );
        }
        // @todo implement exception log persistence layer
        catch ( SearchParamNotFoundException $e ){
            $response = response()->json( ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile() ] );
        }
        catch ( EmptySearchParamException $e ){
            $response = response()->json( ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile() ] );
        }
        catch ( \Exception $e ){
            $response = response()->json( ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile() ] );
        }

        return $response;
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
            $donationData = $request->post('donation' );

            $user = User::create([
                'name'  => $data['name'],
                'email' => $data['email'],
                'cpf'   => $data['cpf'],
                'dob'   => \DateTime::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d')
            ]);

            $currentPaymentType = $donationData['payment'][ 'type' ];
            $userData = UserData::create([
                'id_user' => $user->id,
                'store' => [
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'phone_secondary' => $data['phone_secondary'],
                    'payment_type' => $currentPaymentType
                ]
            ]);


            $donation = Donation::create([
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
                'expire_at_year' => $donationData['payment']['expire_at_year']
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
     * @param  int  $id
     * @return UserResource
     */
    public function show( $id ): UserResource
    {
        $response = null;
        try {
            $response = new UserResource( User::query()->find( $id ) );
        }
        catch ( \Exception $e ){
            // @todo handle exception properly
        }

        return $response;
    }

    /**
     * Update the specified resource in the user/donator storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->post('donator' );
            $donationData = $request->post('donation' );
            // fetches for an user with specified ID, fails otherwise
            $user = User::query()->findOrFail( $id );
            $user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
                'cpf'   => $data['cpf'],
                'dob'   => \DateTime::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d')
            ]);

            $userData = UserData::query()->where('id_user', $id )->firstOrCreate();
            $currentPaymentType = $userData['store'][ 'payment_type' ];
            $newPaymentType = $donationData['payment']['type'];
            unset( $donationData['payment']['type'] ); // unset to avoid upsert execution problems
            $userData->update([
                'store' => [
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'phone_secondary' => $data['phone_secondary'],
                    'payment_type' => $newPaymentType
                ]
            ]);

            $donation = Donation::query()->where('id_user', $id )->update([
                'frequency' => $donationData['frequency'],
                'amount' => \str_replace(',', '.', $donationData['amount'] )
            ]);
            // verifying the current payment method before updating it
            $currentPaymentMethod = PaymentMethod::resolve( $currentPaymentType )->newQuery()->where('id_user', $id )->first();

            if( ($currentPaymentType === $newPaymentType) && $currentPaymentType ){
                $currentPaymentMethod->update( $donationData['payment'] );
            }
            else{
                $currentPaymentMethod->delete();
                PaymentMethod::updatePaymentMethod( $donationData['payment'], $newPaymentType, $id );
            }
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
     * It Soft deletes the id specified resource from user/donator storage.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function destroy( $id ): JsonResponse
    {
        $response = null;
        try {
            User::findOrFail( $id )->update([ 'status' => 0 ] );
            $response = response()->json( [ 'ok' => true ] );
        }catch ( \Exception $e ){
            $response = response()->json(['ok' => false, 'message' => $e->getMessage() ], 421 );
        }

        return $response;
    }
}
