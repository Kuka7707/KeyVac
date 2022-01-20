<template >
         <v-row align="center" justify="center">
            <v-col cols="12" sm="8" md="4">
               <v-card class="elevation-12">
                  <v-toolbar color="primary" dark flat>
                     <v-toolbar-title>Авторизация</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>
                  <v-card-text>
                     <div v-if="authenticated">
                        Вы авторизованы
                        <br>
                        <br>
                        <router-link to="/"><v-btn color="primary">Перейти на главную</v-btn></router-link>
                     </div>
                     <v-form v-else>
                        <v-text-field label="Login" v-model="username" prepend-icon="mdi-account" type="text"></v-text-field>
                        <v-text-field id="password" label="Password" v-model="password" prepend-icon="mdi-lock" type="password"></v-text-field>
                     </v-form>
                  </v-card-text>
                  <v-card-actions v-if="!authenticated">
                     <v-btn color="primary" @click="login">Авторизация</v-btn>
                     <v-spacer></v-spacer>
                     <router-link to="/register"><v-btn text small color="primary">Регистрация</v-btn></router-link>
                  </v-card-actions>
               </v-card>
            </v-col>
         </v-row>
</template>


<script>
export default {
   data() {
      return {
         username: '',
         password: '',
         show1: false,
         authenticated: auth.check(),
      };
   },

   methods: {
      login() {
         let data = {
            username: this.username,
            password: this.password
         };

         axios.post('/api/login', data)
         .then(({data}) => {
            auth.login(data.token, data.user);
            this.$router.push('/main');
         })
         .catch(({response}) => {
            alert(response.data.message);
         });
      },
   },

   mounted(){
      Event.$on('userLoggedOut', () => {
         this.authenticated = false;
         this.user = {};
      })
   }
}
</script>
