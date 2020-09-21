require('./bootstrap');
import router from './routes/index';
import Vuelidate from 'vuelidate';
import VueMask from 'v-mask';
window.Vue = require( 'vue' );

Vue.use( Vuelidate );
Vue.use(VueMask);

Vue.component( 'app', require('./components/app.vue').default );

const app = new Vue({
    el: '#app', router
});
