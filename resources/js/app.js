import './bootstrap';
// Import modules...

import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import CalendarComponent from './components/CalendarComponent.vue'; // Asegúrate de que la ruta es correcta

Vue.use(Vuetify);

Vue.component('calendar-component', CalendarComponent); // Registra el componente globalmente

new Vue({
    vuetify: new Vuetify(),
    el: '#app', // Asegúrate de que coincida con el id del contenedor en tu archivo Blade
    created() {
        console.log('Vue instance mounted');
    }
});
