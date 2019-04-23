
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
import Gate from './Gate.js'
import VueRouter from 'vue-router'
import Chat from './components/Chat'
import Test from './components/Test'
import Customer from './components/Customer'
import Post from './components/Post'
import Home from './components/Home'
import Maps from './components/Maps'
import Appointment from './components/Appointment'
import Dashboard from './components/Dashboard'
import VueProgressBar from 'vue-progressbar'
import Reservation from './components/Reservation'
import Profile from './components/Profile'
import { Form, HasError, AlertError } from 'vform';
import fullCalendar from 'vue-fullcalendar'
import moment from 'moment'
import StarRating from 'vue-star-rating'  
Vue.component('full-calendar', fullCalendar)
Vue.component('star-rating', StarRating);
/*import * as VueGoogleMaps from 'vue2-google-maps'


Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAQ-3qQsQhnBCwQASZhxsDNsPAtzRSieLs',
    libraries: 'places', // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,drawing,visualization'
    // (as you require)
 
    //// If you want to set the version, you can do so:
    // v: '3.26',
  },
 
  //// If you intend to programmatically custom event listener code
  //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
  //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
  //// you might need to turn this on.
  // autobindAllEvents: false,
 
  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  // installComponents: true,
})*/
import swal from 'sweetalert2'
window.swal = swal;
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

window.Form = Form;
Vue.use(VueRouter)
Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'

Vue.prototype.$gate = new Gate(window.user);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '10px'
  })
Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});
// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('PrivateChat', require('./components/Chat.vue').default);
const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)
window.Fire =  new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 let routes = [
    {path:'/locate',component:Maps},
    {path:'/home',component:Home},
    {path: '/test',component:Test},
    {path:'/customers',component:Customer},
    {path:'/posts',component:Post},
    {path:'/appointments',component:Appointment},
    {path:'/dashboard',component:Dashboard},
    {path:'/reservation',component:Reservation},
    {path:'/profile',component:Profile}
    
  ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })


const app = new Vue({
    el: '#app',
    router
});

var pwaCard = document.querySelector('#pwa');
var pwaCardContent = pwaCard.querySelector('.card__content');
var pwaCardDetails = pwaCard.querySelector('.card__details');
var detailsShown = false;

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js')
    .then(function() {
      console.log('SW registered');
    });
}

pwaCard.addEventListener('click', function (event) {
  if (!detailsShown) {
    detailsShown = true;
    pwaCardContent.style.opacity = 0;
    pwaCardDetails.style.display = 'block';
    pwaCardContent.style.display = 'none';
    setTimeout(function () {
      pwaCardDetails.style.opacity = 1;
    }, 300);
  } else {
    detailsShown = false;
    pwaCardDetails.style.opacity = 0;
    pwaCardContent.style.display = 'block';
    pwaCardDetails.style.display = 'none';
    setTimeout(function () {
      pwaCardContent.style.opacity = 1;
    }, 300);
  }
});
