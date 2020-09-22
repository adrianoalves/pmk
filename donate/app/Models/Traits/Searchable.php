<?php
namespace App\Models\Traits;

use App\Models\Traits\Exceptions\EmptySearchParamException;
use App\Models\Traits\Exceptions\SearchParamNotFoundException;
use App\ValueMapper\SearchParams;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * prepare the query builder to execute a search
     * @param array $searchParams
     * @return Builder
     * @throws EmptySearchParamException
     * @throws SearchParamNotFoundException
     */
    public static function prepareSearch( array $searchParams ): Builder
    {
        $statement = self::query();
        if( count( $searchParams ) ){
            self::validateParams( $searchParams );
            switch ( $searchParams['criteria'] ){
                case SearchParams::CRITERIA_EQUALS:
                    $statement->where( $searchParams['field'], '=', $searchParams );
                    break;

                case SearchParams::CRITERIA_CONTAINS:
                    $statement->where( $searchParams['field'], 'like', '%'.$searchParams['sentence'].'%' );
                    break;
            }
        }

        return $statement;
    }

    /**
     * Validates search params before execute the main method
     * @param array $searchParams
     * @return bool
     * @throws EmptySearchParamException
     * @throws SearchParamNotFoundException
     */
    public static function validateParams( array $searchParams ): bool
    {
        foreach ( SearchParams::PARAMS as $key ){
            if( !isset( $searchParams[ $key ] ) )
                throw new SearchParamNotFoundException( "Search param {$searchParams[ $key ]} not found" );
            if( empty( $searchParams[ $key ] ) )
                throw new EmptySearchParamException( "Search param {$searchParams[ $key ]} is empty" );
        }

        return true;
    }
}
