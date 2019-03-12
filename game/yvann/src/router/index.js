import Vue from 'vue'
import Router from 'vue-router'
import accueil from '@/components/accueil'
import game from '@/components/game'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'accueil',
      component: accueil
    },
    {
      path: '/game/:pseudo',
      name: 'game',
      component: game
    }
  ]
})
