import VueRouter from 'vue-router';

let routes = [
   {
      path: '/',
      component: require('./components/Layout.vue').default,
      meta: { middlewareAuth: true }
   },
   {
      path: '/login',
      component: require('./components/Auth/Login.vue').default,
   },
   {
      path: '/register',
      component: require('./components/Auth/Register.vue').default,
   },
   {
      path: '/dashboard',
      name: 'dashboard',
      component: require('./components/views/dashboard/Index.vue').default

   },

   {
      path: '/projects',
      name: 'projects',
      component: require('./components/views/project/List.vue').default,
      props:true      

   },
   {
      path: '/projects/show/:id',
      name: 'project_show',
      component: require('./components/views/project/Index.vue').default,
      meta: {middlewareAuth: true},
      props:true
   },
   {
      path: '/create_project',
      name: 'create_project',
      component: require('./components/views/project/Create.vue').default,
   },
   {
      path: '/projects/edit/:id',
      name: 'project_edit',
      component: require('./components/views/project/Update.vue').default,
      meta: {middlewareAuth: true},
      props:true  
   },
   {
      path: '/tasks',
      component: require('./components/views/tasks/List.vue').default,
   },
   {
      path: '/tasks/show/:id',
      name: 'tasks_show',
      component: require('./components/views/tasks/Detail.vue').default,
      meta: {middlewareAuth: true},
      props:true
   },
   {
      path: '/tasks/edit/:id',
      name: 'tasks_edit',
      component: require('./components/views/tasks/Update.vue').default,
      meta: {middlewareAuth: true},
      props:true
   },
   {
      path: '/users',
      component: require('./components/views/users/List.vue').default,
   },
   {
      path: '/users/show/:id',
      name: 'users_show',
      component: require('./components/views/users/Detail.vue').default,
      meta: {middlewareAuth: true},
      props:true
   },
   {
      path: '/users/edit/:id',
      name: 'users_edit',
      component: require('./components/views/users/Update.vue').default,
      meta: {middlewareAuth: true},
      props:true
   },
   {
      path: '/roles',
      component: require('./components/views/users/Roles.vue').default,
   },

];

const router = new VueRouter({
   routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!auth.check()) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
            return;
        }
    }
    next();
})


export default router;
