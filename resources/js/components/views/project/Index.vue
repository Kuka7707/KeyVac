<template>
<v-container  fluid>
      <v-card>
       <!--  <v-row v-for="item in projects" :key="item.id"> -->
         <v-toolbar color="#27263D" dark>
            <v-toolbar-title><strong>{{this.data.project.name}}</strong></v-toolbar-title>
            <div>                 
                <v-btn class="mx-2" small fab >
                    <v-icon >mdi-lock</v-icon>
                </v-btn>
            </div>
               <v-spacer></v-spacer>                            
                   <v-tooltip top>
        <template v-slot:activator="{ on, attrs }">
          
           <router-link :to="{ name: 'project_edit'}">                
                  <v-btn 
            dark
            v-bind="attrs"
            v-on="on" class="mx-2" small fab >
                     <v-icon >mdi-settings</v-icon>
                  </v-btn>
               </router-link>
         
        </template>
        <span>Редактировать</span>
                   </v-tooltip>
           
            </v-toolbar>
      <!--   </v-row> -->
      </v-card>
      <v-card>
        
          <v-text-field readonly outlined color="#4A148C" v-model="this.data.project.description"></v-text-field>
       
      </v-card>
       <v-card>
      <v-tabs
        color="deep-purple accent-4"
        right
      >
        <v-tab><strong>Задачи</strong></v-tab>
        <v-tab><strong>Участники</strong></v-tab>
        <v-tab-item v-for="n in 1" :key="n">
           <v-container fluid>
            <v-row>
                <v-col>
           <v-simple-table>
               <thead>
                  <tr>
                     <th>Наименование задачи</th>                     
                     <th>Дата завершения</th>
                     <th>Статус</th>
                     <th>Исполнитель</th>
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
                
                     <td>{{task.unit}}</td> 
                  </tr>
               </tbody>
            </v-simple-table>
          </v-col>             
            </v-row>
          </v-container> 
        </v-tab-item>
        <v-tab-item v-for="n in 2" :key="n">
          <v-container fluid>             
                 <v-card>
                  <v-alert> <h3>Участники проекта</h3></v-alert>
                  <span v-if="data.project.admin==='1'"> <v-text-field v-model="admin" readonly outlined color="#4A148C" label="Руководитель"></v-text-field></span>
                  <span v-else><v-text-field v-model="data.project.admin" readonly outlined color="#4A148C" label="Руководитель"></v-text-field></span>
                  <v-alert> <h4>Все участники проекта</h4></v-alert>    
                  <!-- <v-row v-for="items in data.project.participants">  --><v-text-field readonly outlined color="#4A148C" v-model="data.project.participants"></v-text-field>

        </v-card>            
          </v-container>
        </v-tab-item>
      </v-tabs>
       </v-card>
   </v-container>   
</template>
<script>
export default {
  props: ['id'],
     data() {
      return {  
      classes: [],
      data:[],
      projects:{},
      tasks: [],
      statuses:[],
      users:[],
      active: false,
      message: 'hello',
      admin: 'Zhandos Bahtybayev',
      singleSelect: false,
      items2:['Завершить', 'Перенести срок','4'],
     
      selected: [],
     
    }
   
  },
   methods: {
    hoverOver() {        
         this.active =true;
         this.message= 'Добавить проект';
    },
    hoverOut() {     
    },
   /*  getResults() {             
         axios.get('/projects').then(response => {          
            this.data = response.data
            this.projects = response.data.projects;        
            console.log(response)
         });
      }, */
       getUsers() {        
         let params = {}       
         axios.get('/users').then(response => {          
            this.datas = response.data
            this.users = response.data.users;        
            console.log(response)
         });
      },
      getTasks(){
        axios.get('/tasks').then(response => {          
           
            this.tasks = response.data.tasks; 
            this.statuses= response.data.status; 
            console.log(response)
         });
      },
      showInfo() {       
        /*  let params = {id: this.datass.id} */
         axios.get('/projects/show/'+ this.id).then(response => {
            console.log(response)
            this.data = response.data
            this.projects = response.data.project;
         });
      }
   
   },
    mounted(){
   
       this.getUsers();
       this.showInfo();
       this.getTasks();
       
       }
   

    
}
</script>