<template>
   <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
         <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
               <v-toolbar color="primary" dark flat>
                  <v-toolbar-title>Регистрация</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card-text>
                  <v-form>
                     <div v-if="authenticated">
                        Вы авторизованы
                     </div>
                     <div v-else>
                        <v-text-field v-model="firstname" label="FirstName" required></v-text-field>
                        <v-text-field v-model="lastname" label="LastName" required ></v-text-field>
                        <v-text-field v-model="phone" label="Phone" required ></v-text-field>
                        <v-text-field :error-messages="usernameErrors" v-model="username" label="E-mail" required @input="$v.username.$touch()" @blur="$v.username.$touch()" ></v-text-field>
                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Пароль" counter @click:append="show1 = !show1" ></v-text-field>
                     </div>
                  </v-form>
               </v-card-text>
               <v-card-actions>
                  <v-btn class="m-10" @click="register">Зарегистрироваться</v-btn>
                  <v-spacer></v-spacer>
                  <router-link to="/login"><v-btn text small color="primary">Авторизация</v-btn></router-link>
               </v-card-actions>
            </v-card>
         </v-col>
      </v-row>
   </v-container>
</template>

<script>
import { required, maxLength, email} from 'vuelidate/lib/validators'


export default {

   data() {
      return {
         username: '',
         password: '',
         firstname: '',
         lastname: '',
         phone: '',
         select: '',
         checkbox: '',
         show1: false,
         authenticated: auth.check(),
         user: auth.user,
      };
   },

   validations: {
      uname: { required, maxLength: maxLength(10) },
      username: { required, email },
   },

   computed: {
      usernameErrors () {
         const errors = []
         if (!this.$v.username.$dirty) return errors
         !this.$v.username.email && errors.push('Must be valid e-mail')
         !this.$v.username.required && errors.push('E-mail is required')
         return errors
      },
   },

   methods: {
      register() {
         this.$v.$touch()

         let data = {
            username: this.firstname,
            firstname: this.firstname,
            lastname: this.firstname,
            email: this.username,
            password: this.password,
            phone: this.phone,
         };

         axios.post('/api/register', data)
         .then(({data}) => {
            auth.login(data.token, data.user);
            this.$router.push('/main');
         })
         .catch(({response}) => {
            console.log(response)
         });
      },



   }
}
</script>
