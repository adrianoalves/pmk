<?php
namespace App\ValueMapper;

class SearchParams
{
    const CRITERIA_EQUALS   = 'equals';
    const CRITERIA_CONTAINS = 'contains';

    const PARAMS = [
        'field',
        'criteria',
        'sentence'
    ];
}
