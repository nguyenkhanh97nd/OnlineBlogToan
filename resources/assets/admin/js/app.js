// Alert
$("div.alert").delay(3000).slideUp();

// Show menu
$(window).on('load',function() { 
  //thanh menu left
    $('.menu-left > ul > li:first a').next().slideToggle();
  
    $('.menu-left > ul > li > a').click(function(){
        if ($(this).attr('class') != 'active'){
            $('.menu-left ul li ul').slideUp();
            $(this).next().slideToggle();
            $('.menu-left ul li a').removeClass('active');
            $(this).addClass('active');
        }
    });
});


require('./bootstrap')

import Vue from 'vue';

import moment from 'moment'

import App from './components/App.vue'

import Auth from './packages/auth/Auth.js'
Vue.use(Auth)

import Router from './routes/index.js'
Router.beforeEach(
    (to, from, next) => {

        if(to.meta.forVisitors) {
            if(Vue.auth.isAuthenticated())
                next({
                    path: '/admin/dashboard/index'
                })
            else
                next()
        }

        else if(to.meta.forAdmins) {
            if(!Vue.auth.isAuthenticated())
                next({
                    path: '/admin/login'
                })
            else
                next()
        }

        else next()
      
    }
)


import VueSweetAlert from 'vue-sweetalert'
Vue.use(VueSweetAlert)

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#root',
    render: h => h(App),
    router: Router
});
