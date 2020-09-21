<template>
    <div class="row">
        <div class="col-12 text-center">
            <h1>Lista de Doadores</h1>
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
                        <tr v-for="donator in donators">
                            <td scope="col">
                                <button class="btn btn-success">A</button>
                                <button class="btn btn-danger">X</button>
                            </td>
                            <td scope="col">{{donator.name}}</td>
                            <td scope="col">{{donator.email}}</td>
                            <td scope="col">{{donator.cpf}}</td>
                            <td scope="col">{{donator.age}}</td>
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
    </div>
</template>

<script>
export default {
    name: "list",
    data(){
        return {
            behavioral: {
                success: true
            },
            donators: null
        }
    },
    methods: {
        getDonators() {
            axios.get('/api/donators' ).then( ( response ) =>{
                console.log( response );
                this.donators = response.data.data;
            }).catch( error => {

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
