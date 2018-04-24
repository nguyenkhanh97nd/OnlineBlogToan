$("div.alert").delay(3000).slideUp()

import Vue from 'vue'
import moment from 'moment'
import AppClient from './components/AppClient.vue'

import Auth from './packages/auth/AuthClient.js'
Vue.use(Auth)

import Router from './routes/index.js'


// Router.beforeEach(
//     (to, from, next) => {

//         if(to.meta.forAll) {
//             if(!Vue.auth.isAuthenticated())
//                 next({
//                     path: '/'
//                 })
//             else
//                 next()
//         } else next()
      
//     }
// )

import VueSweetAlert from 'vue-sweetalert'
Vue.use(VueSweetAlert)


import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const app_client = new Vue({
    el: '#app_client',
    render: h => h(AppClient),
    router: Router
});
