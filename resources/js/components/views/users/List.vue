<template>

   <v-container class="fill-height" fluid>
      <v-card class="p-4 text-left col-md-12" >
         <v-row>
            <v-col cols="6"><h2>Пользователи</h2></v-col>
               <v-dialog v-model="dialog" persistent max-width="800px">
                  <template v-slot:activator="{ on, attrs }">
                     <v-col cols="6" class="text-right"><v-btn v-bind="attrs" v-on="on"><i class="mdi mdi-account-plus"></i> &nbsp; Добавить</v-btn> </v-col>
                  </template>
                  <v-card>
                     <v-card-title>
                        <span class="headline">Пользователь</span>
                     </v-card-title>
                  <v-card-text>
                     <v-container>
                        <v-row>
                           <v-col cols="12" sm="6">
                             <v-text-field label="Имя" required outlined v-model="users2.firstname" ></v-text-field>
                           </v-col>
                           <v-col cols="12" sm="6">
                             <v-text-field label="Фамилия" v-model="users2.lastname" required outlined></v-text-field>
                           </v-col>
                           <v-col cols="12" sm="6">
                               <v-text-field label="Телефон" v-model="users2.phone" required outlined></v-text-field>
                           </v-col>
                           <v-col cols="12" sm="6">
                               <v-text-field label="Почта" v-model="users2.email" required outlined></v-text-field>
                           </v-col>

                           <v-col cols="12" sm="4">
                              <v-autocomplete :items="genders" label="Пол" v-model="users2.gender"   item-text="name"  item-value="id"></v-autocomplete>
                           </v-col>
                           <v-col cols="12" sm="4">
                             <v-autocomplete :items="roles" v-model="users2.unit" label="Отдел"  item-text="name"  item-value="id"></v-autocomplete>
                           </v-col>
                           <v-col cols="12" sm="4">
                              <v-autocomplete v-model="users2.status"  item-text="name"  item-value="id" :items="statuses" label="Статус"></v-autocomplete>
              
                               </v-col>
                           <v-col cols="12" sm="6">
                              <v-text-field label="Логин" v-model="users2.name" required outlined></v-text-field>
                          
                           </v-col>
                           <v-col cols="12" sm="6">
                               <v-text-field v-model="users2.password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'"
                                    name="input-10-1" label="Пароль" hint="At least 8 characters"
                                    counter @click:append="show1 = !show1"></v-text-field>
                           </v-col>
                        </v-row>
                     </v-container>
                     <small>*Указатель объязательных полей</small>
                  </v-card-text>
                  <v-card-actions>
                     <v-spacer></v-spacer>
                     <v-btn color="blue darken-1" text @click="dialog=false">Закрыть</v-btn>
                     <v-btn color="blue darken-1" text @click="createUser()">Сохранить</v-btn>
                  </v-card-actions>
               </v-card>
            </v-dialog>
         </v-row>
         <hr>
            <v-simple-table>
               <thead>
                  <tr>
                     <th>ФИО</th>
                     <th>Email</th>
                     <th>Телефон</th>
                     <th>Подразделение</th>
                     <th>Дата создания</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="user in users">
                     <td><router-link :to="{name:'users_show', params: {id:user.id}}"><a>{{user.lastname}} {{user.firstname}}</a></router-link></td>
                     <td>{{user.email}}</td>
                     <td>{{user.phone}}</td>
                     <td>{{user.role}}</td>
                     <td>{{user.created_at}}</td>
                  </tr>
               </tbody>
            </v-simple-table>
      </v-card>
   </v-container>
</template>
<script>
export default {
   data(){
      return{
         dialog: false,
         date: null,
         menu: false,
         modal: false,
         show1: false,
         time: null,
         menu2: false,
         modal2: false,
         projects:[],
         genders:[], 
         users2:[],
         statuses:[],
         files: [],
         roles:[],
         users:[],
         password: '',
         rules: {
        required: value => !!value || 'Required.',
        min: value => value.length >= 8 || 'Min 8 characters',
        emailMatch: () => (`The email and password you entered don't match`),
      }
      }
   },
   methods:{
      getUsers(){
         axios.get('/users').then(response => {             
            this.users = response.data.users;        
            console.log(response)
         });
      },
       getProjects() {             
         axios.get('/projects').then(response => {                     
            this.projects = response.data.projects;            
         });
      },
      createUser(){
         axios.put('/users/create',{
         name: this.users2.name,
         first_name: this.users2.firstname,
         last_name: this.users2.lastname,
         phone: this.users2.phone,
         email: this.users2.email,
         role: this.users2.unit,
         gender: this.users2.gender,
         password: this.users2.password,
         status: this.users2.status
         }).then(response  => { 
            console.log(response)
            dialog=false })
      },
       getStatuses(){
          axios.get('/users_statuses').then(response => {          
            this.statuses = response.data.statuses;        
            console.log(response)
         });
       }, 
       getGenders(){
          axios.get('/genders').then(response => {          
            this.genders = response.data.genders;        
            console.log(response)
         });

       }
   },
   mounted(){
      let self = this;
      axios.get('/roles').then((response) => (
         response.data.map(function(item, i){
            self.roles.push(item.name)
         })
      ));
       this.getUsers();
       this.getProjects();
       this.getStatuses();
       this.getGenders();
   }
}
</script>

<style scoped>
img{
   margin-right: 10px;
}
</style>
