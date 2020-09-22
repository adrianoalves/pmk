<?php
namespace App\Service;

use App\Models\PaymentMethod\Credit;
use App\Models\PaymentMethod\Debit;
use App\Service\Exception\PaymentMethodNotFoundException;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod
{
    /**
     * Resolves the proper payment method model, otherwise it throws an specialized exception
     * @param int $type
     * @return Model
     * @throws PaymentMethodNotFoundException
     */
    public static function resolve( int $type ): Model
    {
        $model = null;
        switch ( $type ){
            case \App\ValueMapper\PaymentMethod::PAYMENT_CREDIT:
                $model = new Credit();
                break;
            case \App\ValueMapper\PaymentMethod::PAYMENT_DEBIT:
                $model = new Debit();
                break;
            default:
                throw new PaymentMethodNotFoundException('Payment Method not Found' );
                break;
        }
        return $model;
    }

    /**
     * Updates user payment method
     * @param array $data payment data array
     * @param int $type payment method type
     * @param int $idUser payment owner user id
     * @return bool true on success
     * @throws PaymentMethodNotFoundException
     */
    public static function updatePaymentMethod( array $data, $type, int $idUser ): bool
    {
        $data['id_user'] = $idUser;
        $newPaymentMethod = self::resolve( $type )->fill( $data );
        return $newPaymentMethod->save();
    }
}
