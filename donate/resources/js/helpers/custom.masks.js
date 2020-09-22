import createNumberMask from 'text-mask-addons/dist/createNumberMask';

/**
 * custom currency mask for monetary fields
 */
export const currencyMask = createNumberMask({
    prefix: '',
    allowDecimal: true,
    decimalSymbol: ',',
    includeThousandsSeparator: false,
    allowNegative: false,
});
