<template>
    <div>
        <div class="row">
            <div class="col text-center">
                <h5 class="text-info my-2 text-bold">Doador</h5>
            </div>
        </div>
        <form @submit.prevent="post">
            <div class="card">
                <div class="card-body">

                    <div class="form-row">

                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="name" name="name"
                                   placeholder="Nome Completo do Doador" v-model.trim="$v.user.name.$model"
                                   :class="!$v.user.name.minLength ? 'is-invalid' : 'is-valid'">
                            <label for="name">Nome Completo</label>
                            <div class="invalid-feedback">por favor, digite o nome completo</div>
                        </div>
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                   placeholder="Email" v-model.trim="$v.user.email.$model"
                                   :class="!($v.user.email.required && $v.user.email.email) ? 'is-invalid' : 'is-valid'">
                            <label for="email">Email</label>
                            <div class="invalid-feedback">por favor, informe um email válido</div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="cpf" name="cpf"
                                   placeholder="CPF"
                                   :class="!($v.user.cpf.required) ? 'is-invalid' : 'is-valid'"
                                   v-mask="'###.###.###-##'" v-model.trim="$v.user.cpf.$model">
                            <label for="cpf">CPF</label>
                            <div class="invalid-feedback">por favor, digite o seu CPF</div>
                        </div>
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" maxlength="10" class="form-control form-control-lg" id="dob" name="dob"
                                   placeholder="Data de Nascimento (DD/MM/AAAA)" v-model.trim="$v.user.dob.$model"
                                   :class="!($v.user.dob.required) ? 'is-invalid' : 'is-valid'" v-mask="'##/##/####'">
                            <label for="dob">Data de Nascimento</label>
                            <div class="invalid-feedback">por favor, informe a sua data de nascimento</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="phone" name="phone"
                                   placeholder="DDD + Telefone de Contato" v-model.trim="$v.user.phone.$model"
                                   :class="!($v.user.phone.required && $v.user.phone.minLength ) ? 'is-invalid' : 'is-valid'"
                                   v-mask="'(##) #####-####'">
                            <label for="phone">Telefone Principal</label>
                            <div class="invalid-feedback">por favor, digite o seu telefone de contato</div>
                        </div>
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="phone_secondary"
                                   name="phone_secondary" placeholder="DDD + Telefone Alternativo"
                                   v-model.trim="$v.user.phone_secondary.$model"
                                   :class="( $v.user.phone_secondary.$invalid ) ? 'is-invalid' : 'is-valid'"
                                   v-mask="'(##) #####-####'">
                            <label for="phone_secondary">Telefone Alternativo</label>
                            <div class="invalid-feedback">por favor, informe um telefone adicional</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-label-group col-lg-3 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="cep" name="cep"
                                   placeholder="CEP Residencial" v-model.trim="$v.user.address.cep.$model"
                                   :class="( $v.user.address.cep.$invalid ) ? 'is-invalid' : 'is-valid'"
                                   v-mask="'#####-###'">
                            <label for="cep">CEP</label>
                            <div class="invalid-feedback">por favor, informe o seu CEP</div>
                        </div>
                        <div class="form-label-group col-lg-3 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="address_number"
                                   name="address_number" placeholder="Número"
                                   v-model.trim="$v.user.address.number.$model"
                                   :class="!($v.user.address.number.required) ? 'is-invalid' : 'is-valid'">
                            <label for="address_number">Número</label>
                            <div class="invalid-feedback">por favor, o número da sua residência</div>
                        </div>
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg is-valid" id="address_complement"
                                   name="address_complement" placeholder="Complemento de Endereço"
                                   v-model.trim="$v.user.address.complement.$model"
                            >
                            <label for="address_complement">Complemento</label>
                            <div class="valid-feedback">Complemento de Endereço</div>
                        </div>

                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col text-center">
                    <h5 class="text-info my-2 text-bold">Dados para Doação</h5>
                </div>
            </div>
            <!--  Payment Data -->
            <div class="card">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-12 col-md-12 text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_credit" value="1"
                                    v-model="$v.donation.payment.type.$model">
                                <label class="form-check-label" for="payment_type_credit">Crédito</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_debit" value="2"
                                       v-model="$v.donation.payment.type.$model">
                                <label class="form-check-label" for="payment_type_debit">Débito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="name_on_card" name="name_on_card"
                                   placeholder="Nome no Cartão" v-model.trim="$v.donation.payment.name_on_card.$model"
                                   :class="!($v.donation.payment.name_on_card.required) ? 'is-invalid' : 'is-valid'">
                            <label for="email">Nome do Titular</label>
                            <div class="invalid-feedback">por favor, informe o nome do titular como escrito no cartão</div>
                        </div>
                        <div class="form-label-group col-lg-6 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="donation_card_number" name="donation_card_number"
                                   placeholder="Número do Cartão" v-model.trim="$v.donation.payment.card_number.$model" maxlength="10"
                                   :class="($v.donation.payment.card_number.$invalid) ? 'is-invalid' : 'is-valid'"
                                   v-mask="'#### #### #### ####'">
                            <label for="email">Número do Cartão</label>
                            <div class="invalid-feedback">por favor, informe o número do Cartão</div>
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <select class="custom-select custom-select-lg" id="expire_at_month" name="expire_at_month"
                                    v-model="$v.donation.payment.expire_at_month.$model"
                                    :class="!($v.donation.payment.expire_at_month.required) ? 'is-invalid' : 'is-valid'">
                                <option disabled>Selecione o mês de Validade do Cartão</option>
                                <option v-for="month in ['01','02','03','04','05','06','07','08','09','10','11','12']" :value="month">{{month}}</option>
                            </select>
                            <label for="expire_at_month">Mês de Validade</label>
                            <div class="invalid-feedback">por favor, informe o mês de validade do cartão</div>
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <select class="custom-select custom-select-lg" id="expire_at_year" name="expire_at_year"
                                    v-model="$v.donation.payment.expire_at_year.$model"
                                    :class="!($v.donation.payment.expire_at_year.required) ? 'is-invalid' : 'is-valid'">
                                <option disabled>Selecione o Ano de Validade do Cartão</option>
                                <option v-for="year in [21, 22,23,24, 25, 26, 27]">{{year}}</option>
                            </select>
                            <label for="expire_at_year">Ano de Validade</label>
                            <div class="invalid-feedback">por favor, informe o Ano de validade do cartão</div>
                        </div>

                        <div class="form-label-group col-lg-3 col-md-12">
                            <input type="text" class="form-control form-control-lg" id="donation_amount" name="donation_amount"
                                   placeholder="Valor da Doação" v-model.trim="$v.donation.amount.$model" maxlength="10"
                                   :class="($v.donation.amount.$invalid) ? 'is-invalid' : 'is-valid'"
                                    v-mask="customMasks.currency">
                            <label for="email">Valor da Doação</label>
                            <div class="invalid-feedback">por favor, informe o valor da doação</div>
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <select class="custom-select custom-select-lg"
                                    v-model="$v.donation.frequency.$model"
                                    :class="!($v.donation.frequency.required) ? 'is-invalid' : 'is-valid'">
                                <option disabled>Selecione a Recorrência da Doação</option>
                                <option value="1">Única</option>
                                <option value="2">Bimestral</option>
                                <option value="3">Semestral</option>
                                <option value="4">Anual</option>
                            </select>
                            <label for="email">Recorrência</label>
                            <div class="invalid-feedback">por favor, informe o valor da doação</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row my-3" v-if="behavioral.error">
                <div class="col text-center">
                    <div class="alert alert-danger" role="alert">
                        <h6>Ops!</h6>
                        Por favor, corrija os erros no form para prosseguir com o Cadastro.
                    </div>
                </div>
            </div>
             <div class="row my-3" v-if="behavioral.success">
                <div class="col text-center">
                    <div class="alert alert-success" role="alert">
                        <h6>Ok!</h6>
                        Novo Doador Cadastrado!
                    </div>
                </div>
            </div>

            <div class="row my-3" v-if="behavioral.sending">
                <div class="col text-center">
                    <div class="alert alert-warning" role="alert">
                        Inserindo novo Doador...
                    </div>
                </div>
            </div>

            <div class="row my-3" v-if="!behavioral.sending">
                <div class="col text-center">
                    <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                    <router-link class="btn btn-danger btn-lg ml-3" :to="{ name: 'home' }">Voltar</router-link>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
import {required, minLength, email, decimal} from 'vuelidate/lib/validators';
import createNumberMask from 'text-mask-addons/dist/createNumberMask';

const currencyMask = createNumberMask({
    prefix: '',
    allowDecimal: true,
    decimalSymbol: ',',
    // requireDecimal: true,
    // decimalLimit: 2,
    // integerLimit: 8,
    includeThousandsSeparator: false,
    allowNegative: false,
});

export default {
    name: "donate",
    data() {
        return {
            behavioral: {
                sending: false, error: false, success: false,
            },
            customMasks: {
                currency: currencyMask
            },
            user: {
                name: 'Adriano Alves',
                email: 'email@email.com',
                cpf: '29549217817',
                dob: '21/12/1980', // date of birth( data de nascimento )
                phone: '11971783716',
                phone_secondary: '11971783717',
                address: {
                    cep: '04905000', number: '100', complement: 'casa'
                }
            },
            donation: {
                frequency: 1,
                amount: '100,00',
                payment: {
                    type: 1,
                    name_on_card: 'adriano a silva',
                    card_number: '1234567812345678',
                    expire_at_month: 12,
                    expire_at_year: 2025
                }
            }
        }
    },
    validations: {
        user: {
            name: {
                required,
                minLength: minLength(4)
            },
            email: {
                required, email
            },
            cpf: {
                required,
                minLength: minLength(14)
            },
            dob: {
                required, minLength: minLength(10)
            },
            phone: {
                required, minLength: minLength(14)
            },
            phone_secondary: {
                minLength: minLength(14)
            },

            address: {
                cep: {required},
                number: {required},
                complement: {required}
            }
        },

        donation: {
            amount: {
                required, minLength: minLength(4)
            },
            frequency: { required },
            payment: {
                type: { required },
                name_on_card: { required },
                card_number: { required },
                expire_at_month: { required },
                expire_at_year: { required }
            }
        }
    },

    methods: {
        post() {
            this.$v.$touch();
            if( this.$v.$invalid ){
                this.behavioral.error = true;
            }
            else{
                this.behavioral.sending = true;
                this.behavioral.error = false;
                axios.post( '/api/donators', { donator: this.user, donation: this.donation } ).then( res => {
                    console.log( res.data );
                    if( res.status === 200 )
                        this.behavioral.success = true;

                    this.behavioral.sending = false
                })
                .catch( error => {
                    this.behavioral.error   = true;
                    this.behavioral.success, this.behavioral.sending = false;
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
