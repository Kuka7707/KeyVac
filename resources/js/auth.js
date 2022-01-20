class Auth {
   constructor() {
      this.token = window.localStorage.getItem('token');

      let userData = window.localStorage.getItem('user');
      this.user = userData ? JSON.parse(userData) : null;

      if (this.token) {
         axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
         this.getUser();
      }

   }

   getUser() {
      api.call('get', '/api/get-user').then(({data}) => {
         this.user = data;
      });
   }

   login (token, user) {
      window.localStorage.setItem('token', token);
      window.localStorage.setItem('user', JSON.stringify(user));

      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

      this.token = token;
      this.user = user;

      Event.$emit('userLoggedIn');
   }


   logout() {

      axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
      axios.post('/api/logout').then(response => {
         window.localStorage.removeItem('user');
         window.localStorage.removeItem('token');
         this.token = null;
         this.user = {};
         Event.$emit('userLoggedOut');
      }).catch(error => {
         delete axios.defaults.headers.common['Authorization'];
         Event.$emit('userLoggedOut');
         window.localStorage.removeItem('user');
         window.localStorage.removeItem('token');
         this.token = null;
         this.user = {}
      });


   }

   check () {
      return !! this.token;
   }


}

export default Auth;
