<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function getByIdUser( $id )
    {
        $response = null;
        try{

            $response = response()->json( Donation::query()->where( 'id_user', $id )->firstOrFail([ 'frequency', 'amount' ])->toArray() );
        }
        catch ( \Exception $e ){
            $response = response()->json(['ok' => false, 'message' => $e->getMessage() ], 421 );
        }

        return $response;
    }
}
