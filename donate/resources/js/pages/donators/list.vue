<template>
    <div class="row">
        <div class="col-12 my-4">
            <h4 class="text-primary text-center">Lista de Doadores</h4>
        </div>
        <!-- search component -->
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-12">
                    <form class="form-inline" @submit.prevent="search">
                        <!--                    <label class="my-1 mr-2" for="field"></label>-->
                        <select class="custom-select mr-2 ml-3" id="field" v-model="searchParams.field">
                            <option disabled>Escolha o Campo</option>
                            <option value="name" selected>Nome</option>
                            <option value="email">Email</option>
                            <option value="cpf">CPF</option>
                        </select>

                        <select class="custom-select my-1 mr-2" id="criteria" v-model="searchParams.criteria">
                            <option value="equals" selected>Igual</option>
                            <option value="contains">Contém</option>
                        </select>

                        <input type="text" class="form-control mr-2" id="sentence" placeholder="Digite sua Busca" v-model="$v.searchParams.sentence.$model">

                        <button type="submit" class="btn btn-success">Pesquisar</button>
                        <div class="alert alert-warning" role="alert" v-if="behavioral.error">
                            Por favor, informe um valor para efetuar a busca
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- table grid component -->
        <div class="col-12 ">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Idade</th>
                </tr>
                </thead>
                <tbody>
                    <template v-if="donators">
                        <tr v-for="(donator,idx) in donators" v-if="!behavioral.loading">
                            <td scope="col">
                                <button class="btn btn-sm btn-success" @click="toEdit( donator.id )">editar</button>
                                <button class="btn btn-sm btn-danger" @click="remove( donator.id, idx )">remover</button>
                            </td>
                            <td scope="col">{{donator.name}}</td>
                            <td scope="col">{{donator.email}}</td>
                            <td scope="col">{{donator.cpf}}</td>
                            <td scope="col">{{donator.age}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" v-if="behavioral.loading">
                                <div class="alert alert-info">
                                    Processando Solicitação...
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-danger" role="alert">
                                    <h6>Ops!</h6>
                                    Não foram encontrados dados de Doadores.
                                </div>
                            </td>
                        </tr>

                    </template>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <router-link class="btn btn-success btn-lg ml-3" :to="{ name: 'home' }">Home</router-link>
        </div>
    </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
export default {
    name: "list",
    data(){
        return {
            behavioral: {
                error: false, loading: false
            },
            searchParams: {
                field: null,
                criteria: null,
                sentence: null
            },

            donators: null
        }
    },

    validations: {
        searchParams: {
            sentence: { required }
        }
    },
    methods: {
        /**
         * get all donators or search by criteria params
         * @param {Object} params
         */
        getDonators( params ) {
            this.behavioral.loading = true;
            axios.get('/api/donators', {params} ).then( ( response ) =>{
                this.donators = response.data.data;
                this.behavioral.error = false
                this.behavioral.loading = false;
            }).catch( error => {
                this.behavioral.error = true;
                this.behavioral.loading = false;
            });
        },
        /**
         * search method
         */
        search() {
            this.$v.$touch();
            if( this.$v.$invalid ){
                this.behavioral.error = true;
            }
            else{
                this.getDonators( this.searchParams );
            }
        },
        /**
         * route to edit user view
         * @param {Number} id
         */
        toEdit(id) {
            this.$router.push({'name': 'edit', params: { id: id } })
        },
        /**
         * Remove a donator from the donator list
         * @param {Number} id donator identifier
         * @param {Number} idx donator list index
         */
        remove(id, idx) {
            this.behavioral.loading = true;
            axios.delete(`/api/donators/${id}` ).then( response => {
                this.donators.splice( idx, 1 );
                this.behavioral.loading = false;
            }).catch( error => {
                this.behavioral.loading = false;
            });
        }
    },
    mounted() {
        this.getDonators();
    }
}
</script>

<style scoped>

</style>
