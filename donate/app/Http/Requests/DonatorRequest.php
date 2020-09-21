<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'donator.name' => 'required',
            'donator.email' => 'required|email',
            'donator.cpf' => 'required',
            'donator.phone' => 'required'
        ];
    }

    /**
     * It returns custom error messages to Donator Api Post and PUT Requests
     * @return array
     */
    public function messages(): array
    {
        return [
            'donator.name' => [
                'required' => 'Por favor, informe o Nome do Doador'
            ],
            'donator.email' => [
                'required' => 'Por favor, digite o email do Doador',
                'email' => 'Por favor, informe um email correto'
            ],
            'donator.cpf' => 'Por favor, informe o CPF do Doador',
            'donator.phone' => 'Por favor, informe o Telefone do Doador'
        ];
    }
}
