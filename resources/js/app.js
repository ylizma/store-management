import './bootstrap';
import Vue from 'vue';
import store from '@/js/store/store.js'
import router from '@/js/routes.js';
import App from '@/js/views/App';
import VueProgressBar from 'vue-progressbar'
import vueNumeralFilterInstaller from 'vue-numeral-filter'

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.logedIn) {
      next({
        path: '/login'
      })
    }else   if (to.matched.some(record => record.meta.requiresVisitor)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters.logedIn) {
      next({
        path: '/produit'
      })
    } else {
      next()
    }
  }
     else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

const options = {
  color: '#0AFF',
  failedColor: '#874b4b',
  thickness: '3px',
  height:'3px'
}

Vue.use(VueProgressBar, options)
Vue.use(vueNumeralFilterInstaller, { locale: 'en-gb' });

Vue.config.productionTip = false
const app=new Vue({
	el:'#app',
	router,
	store,
  vueNumeralFilterInstaller,
	VueProgressBar,
	render:h=>h(App),
});

export default app;
