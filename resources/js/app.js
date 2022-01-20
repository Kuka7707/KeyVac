
require('./bootstrap');


import router from './routes.js';
import VueRouter from 'vue-router';
import Auth from './auth.js';
import 'vuetify/dist/vuetify.min.css'

import Vuetify from 'vuetify'
import Vue from 'vue'
import { validationMixin } from 'vuelidate'
import Vuelidate from 'vuelidate'
import VueChatScroll from 'vue-chat-scroll'
import VueAgile from 'vue-agile';
import Api from './api.js';




window.Vue = require('vue');
window._ = require('lodash');
window.axios = require('axios');
window.api = new Api();

Vue.use
Vue.use(Vuelidate)
Vue.use(VueChatScroll);
Vue.use(Vuetify)
Vue.use(VueRouter);
Vue.use(VueAgile);


const opts = {}
export default new Vuetify(opts)
window.auth = new Auth();
window.Event = new Vue;




Vue.component('vue-layout', require('./components/Layout.vue').default);

// Vue.component('passport-clients',require('./components/passport/Clients.vue').default);
// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );
// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );

const app = new Vue({
   el: '#app',
   router,
   vuetify: new Vuetify(),
   mixins: [validationMixin],
   iconfont: 'mdi' // 'md' || 'mdi' || 'fa' || 'fa4'
});
