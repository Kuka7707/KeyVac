<template>
<v-container  fluid >   
      <v-card class="mx-auto">
         <v-toolbar color="#27263D" dark>
            <v-col cols="12" md="8"> 
              <v-toolbar-title >Редактирование пользователя</v-toolbar-title> 
         
           </v-col>  
              
               <v-col cols="12" md="4">                          
                  <router-link to="/users">                
                    <v-btn  @click="update()" class="success">
                       Сохранить
                    </v-btn>
                  </router-link>
                   <router-link to="/users">                
                    <v-btn class="error"  >
                      Удалить
                    </v-btn>
                  </router-link>
                   <router-link to="/users">                
                    <v-btn class="error"  >
                       Закрыть
                    </v-btn>
                  </router-link>
               </v-col>
               
            </v-toolbar>
      </v-card>
      <v-row>
         <v-col cols="12" md="8">
            
      <v-card elevation="2"  class="mx-auto "  outlined>
        
         <v-card-text> <v-text-field label="Имя" outlined color="#4A148C" v-model="data.firstname"></v-text-field>
                
             <v-text-field label="Фамилия" outlined color="#4A148C" v-model="data.lastname"></v-text-field>
                </v-card-text>
          <!-- <v-card-title> <v-autocomplete v-model="data.status"  item-text="name"  item-value="id" :items="statuses" label="Статус">
                              <span v-if="data.status_id===1">В работе</span>
                        <span v-if="data.status_id===2">Новый</span>
                        <span v-if="data.status_id===3">Завершено</span>
                        </v-autocomplete>
         </v-card-title> -->
             
        
            
      
      </v-card>
         </v-col>
         <v-col cols="12" md="4">
            <v-card elevation="2" class="mx-auto"  outlined>
               <v-card-text>
                   <v-autocomplete v-model="data.role"  item-text="name"  item-value="id" :items="roles" label="Подразделение"></v-autocomplete>
                </v-card-text>
               <v-card-text>
                   <v-autocomplete v-model="data.status"  item-text="name"  item-value="id" :items="statuses" label="Статус"></v-autocomplete>
                      </v-card-text>
                 
            </v-card>
         </v-col>
      </v-row>
      <v-row>
        
         <v-col cols="12" md="6">
            <v-card elevation="2" class="mx-auto"  outlined>
               <v-card-text>
                     <v-text-field readonly label="Почта" outlined color="#4A148C" v-model="data.email"></v-text-field>
                </v-card-text>
                <v-card-text>
                     <v-text-field readonly label="Телефон" outlined color="#4A148C" v-model="data.phone"></v-text-field>
                </v-card-text>         
            </v-card>
         </v-col>  
      </v-row>
      <v-row>
          <v-col>
              <v-card elevation="2" class="mx-auto"  outlined>
                  <v-card-text>
                       <v-text-field label="Логин" outlined color="#4A148C" v-model="data.name"></v-text-field>
                  </v-card-text>
                  <v-card-text>
                       <v-text-field :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'"
                                    name="input-10-1" label="Пароль" hint="At least 8 characters"
                                    counter @click:append="show1 = !show1"  outlined color="#4A148C" v-model="this.data.password"></v-text-field>
                  </v-card-text>
               
              </v-card>
          </v-col>
      </v-row>
   </v-container>    
</template>
<script>
export default {
    props: ['id'],
    data() {
        return {  
          data: [],
          show1: false,
          password:'',
          rules: {
        required: value => !!value || 'Required.',
        min: value => value.length >= 8 || 'Min 8 characters',
        emailMatch: () => (`The email and password you entered don't match`)},
        roles:[],
        statuses: []

      }
    },
    methods:{
        showInfo() {       
            axios.get('/users/show/'+ this.id).then(response => {
                console.log(response)
                this.data = response.data.user
            });
        },
        update(){
            axios.post('/users/update/'+ this.id,{
                name: this.data.name,
                firstname: this.data.firstname,
                lastname: this.data.lastname,
                email: this.data.email,
                phone: this.data.phone,
                status: this.data.status,
                role: this.data.role,
                password: this.data.password
            }).then(response => {
                console.log(response)
            });
        },
        getStatuses(){
          axios.get('/users_statuses').then(response => {          
            this.statuses = response.data.statuses;        
            console.log(response)
         });

      },
      destroy(){
          axios.post('/users/delete/'+this.id,{
              

          }).then(response => {console.log(response);});

      },

    },
    mounted(){
        let self = this;
      axios.get('/roles').then((response) => (
         response.data.map(function(item, i){
            self.roles.push(item.name)
         })
      ));
      this.showInfo();
      this.getStatuses();
      this.destroy();

    }
    
}
</script>