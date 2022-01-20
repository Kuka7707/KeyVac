<template>
      <v-container class="fill-height" fluid>
         <v-card class="p-4 text-left col-md-12" >
            <v-card>
         <v-toolbar color="#27263D" dark>
            <v-toolbar-title>Задачи</v-toolbar-title>
               <v-spacer></v-spacer>
               <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                     
                  <v-btn 
            v-bind="attrs"
            v-on="on"  class="mx-2" @click="dialog=true" small fab dark color="#27263D">
                     <v-icon large>mdi-plus-circle-outline</v-icon>
                  </v-btn>       
        </template>
        <span>Добавить новую задачу</span>
               </v-tooltip> 
            </v-toolbar>
      </v-card>
            <v-row>
               <v-dialog v-model="dialog" persistent max-width="800px">
           <v-card>
                     <v-card-title>
                     <span class="headline"><a>Новая задача</a></span>
                     </v-card-title>
                     <v-card-text>
                        <v-container>
                           <v-row>
                              <v-col cols="12">
                                 <v-text-field label="Наименование*" required v-model="tasks2.name"></v-text-field>
                              </v-col>
                              <v-col cols="12">
                                 <v-textarea outlined name="input-7-4" label="Описание" v-model="tasks2.description"></v-textarea>
                              </v-col>

                              <v-col cols="12" sm="6">
                                 <v-autocomplete  item-text="name"  item-value="name" v-model="tasks2.project_id" :items="projects" label="Проект"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" sm="6">
                                 <v-autocomplete v-model="tasks2.status_id"  item-text="name"  item-value="id" :items="statuses" label="Статус"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" sm="6">
                                 <v-autocomplete :items="roles" v-model="tasks2.unit" label="Отдел"  item-text="name"  item-value="id"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" sm="6">
                                 <v-autocomplete :items="users" v-model="tasks2.executor_uid" label="Исполнитель"  item-text="firstname"  item-value="firstname"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" sm="6">
                                 <v-autocomplete :items="users" v-model="tasks2.co_executor_uid" label="Соисполнитель"  item-text="firstname"  item-value="firstname"></v-autocomplete>
                              </v-col>
                              <v-col cols="12" sm="6">
                                 <v-autocomplete :items="users" v-model="tasks2.owner_uid" label="Ответственный"  item-text="firstname"  item-value="id"></v-autocomplete>
                              </v-col>

                              <v-col cols="12" sm="6">
                                 <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                       <v-text-field v-model="tasks2.end" label="Дата" prepend-icon="event" readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tasks2.end" @input="menu = false"></v-date-picker>
                                 </v-menu>
                              </v-col>

                              <v-col cols="6" sm="6">
                                 <v-menu ref="menu" v-model="menu2" :close-on-content-click="false" :nudge-right="40" :return-value.sync="time" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                       <v-text-field v-model="time" label="Время" prepend-icon="access_time" readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker format="24hr" v-if="menu2" v-model="time" full-width @click:minute="$refs.menu.save(time)"></v-time-picker>
                                 </v-menu>
                              </v-col>
                              <v-col cols="12">
                                 <v-file-input v-model="files" color="deep-purple accent-4" label="Прикрепить файл" multiple placeholder="Выберите файл" prepend-icon="mdi-paperclip" outlined :show-size="1000">
                                 </v-file-input>
                              </v-col>
                           </v-row>
                        </v-container>
                        <small>*Указатель объязательных полей</small>
                     </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="dialog = false">Закрыть</v-btn>
                        <v-btn color="blue darken-1" text @click="addNewTask()">Сохранить</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-dialog>
            </v-row>
            <hr>
            <v-simple-table>
               <thead>
                  <tr>
                     <th>Наименование задачи</th>                     
                     <th>Дата завершения</th>
                     <th>Статус</th>
                     <th>Исполнитель</th>
                     <th>Проект</th>
                     <th>Отдел</th>
                   
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="task in tasks">
                     <td><router-link :to="{name:'tasks_show', params: {id:task.id}}"><a>{{task.name}}</a></router-link></td>
                     <td>{{task.end}}</td>
                     <td><span  v-if="task.status_id=== 1"> В работе</span>
                        <span  v-else-if="task.status_id=== 2"> Новый</span>
                        <span  v-else-if="task.status_id=== 3"> Завершено</span>
                       </td>
                     <td>{{task.executor_uid}}</td>
                     <td>{{task.project_id}}</td>
                     <td>{{task.unit}}</td> 
                  </tr>
               </tbody>
            </v-simple-table>
         </v-card>
      </v-container>
</template>

<script>
export default {
   props: ['id'],

   data(){
      return{
         dialog: false,
         date: null,
         data:[],
         menu: false,
         modal: false,
         time: null,
         menu2: false,
         modal2: false,
         files: [],
         roles: [],
         users: [],
         tasks:[],
         tasks2:[],
         statuses:[],
         projects: []
      }
   },  
   methods: {
    getResults() {             
         axios.get('/tasks').then(response => {          
            this.data = response.data
            this.tasks = response.data.tasks; 
            this.statuses= response.data.status; 
            console.log(response)
         });
      },
      addNewTask(){
        axios.put('/create_task',{
          name: this.tasks2.name,
          status_id:this.tasks2.status_id,
          executor_uid:this.tasks2.executor_uid,
          co_executor_uid:this.tasks2.co_executor_uid,
          description:this.tasks2.description,
          owner_uid:this.tasks2.owner_uid,
          project_id:this.tasks2.project_id,
          files:this.files,
          unit: this.tasks2.unit,
          end: this.tasks2.end
         }).then(response  => { 
            console.log(response)
            dialog=false 
            this.$notify({
               group: "alert",
               title: 'Успешно',
               type: 'primary',
               text: 'Сохранено',
               duration: 10000
            });
         })       
      },
      getProjects() {             
         axios.get('/projects').then(response => {                     
            this.projects = response.data.projects;            
         });
      },
       getUsers(){
         axios.get('/users').then(response => {          
            
            this.users = response.data.users;        
            console.log(response)
         });
      },
   },
   mounted(){
      let self = this;
      axios.get('/roles').then((response) => (
         response.data.map(function(item, i){
            self.roles.push(item.name)
         })
      ));
      this.getResults();
      this.getProjects();
      this.getUsers();
   }
}
</script>
<style scoped>
img{
   margin-right: 10px;
}
</style>
