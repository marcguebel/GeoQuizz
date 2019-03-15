import Vue from 'vue'
import Router from 'vue-router'
import accueil from '@/components/accueil'
import game from '@/components/game'
import leaderboard from '@/components/leaderboard'
import allLeaderboard from '@/components/allLeaderboards'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'accueil',
      component: accueil
    },
    {
      path: '/game/:idSerie/:pseudo?',
      name: 'game',
      component: game
    },
    {
      path: '/leaderGame/:idSerie',
      name: 'leaderboard',
      component: leaderboard
    },
    {
      path: '/leaderboard',
      name: 'allLeaderboard',
      component: allLeaderboard
    }
  ]
})
