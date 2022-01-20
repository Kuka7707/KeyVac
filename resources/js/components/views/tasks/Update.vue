<template>
     <v-container  fluid >   
      <v-card class="mx-auto">
         <v-toolbar color="#27263D" dark>
            <v-col cols="12" md="8"> 
              <v-toolbar-title >Редактирование задачи</v-toolbar-title> 
           </v-col>         
               <v-col cols="12" md="4">                          
                  <router-link to="/tasks">                
                    <v-btn  @click="update()" class="success">
                       Сохранить
                    </v-btn>
                  </router-link>
                   <router-link to="/tasks">                
                    <v-btn class="error" @click="destroy()" >
                      Удалить
                    </v-btn>
                  </router-link>
                   <router-link to="/tasks">                
                    <v-btn class="error">
                       Закрыть
                    </v-btn>
                  </router-link>
               </v-col>  
            </v-toolbar>
      </v-card>
      <v-row>
         <v-col cols="12" md="8">
      <v-card elevation="2"  class="mx-auto "  outlined>     
         <v-card-text> <v-text-field label="Название" outlined color="#4A148C" v-model="data.name"></v-text-field>           
             <v-text-field label="Описание" outlined color="#4A148C" v-model="data.description"></v-text-field>
                 </v-card-text>
          <v-card-title> <v-autocomplete v-model="data.status_id"  item-text="name"  item-value="id" :items="statuses" label="Статус">
                              <span v-if="data.status_id===1">В работе</span>
                        <span v-if="data.status_id===2">Новый</span>
                        <span v-if="data.status_id===3">Завершено</span>
                        </v-autocomplete>
         </v-card-title>
      </v-card>
         </v-col>
         <v-col cols="12" md="4">
            <v-card elevation="2" class="mx-auto"  outlined>
               <v-card-text>
                   <v-autocomplete v-model="data.executor_uid"  item-text="firstname"  item-value="firstname" :items="users" label="Исполнитель"></v-autocomplete>
                </v-card-text>
               <v-card-text>
                   <v-autocomplete v-model="data.co_executor_uid"  item-text="firstname"  item-value="firstname" :items="users" label="Соисполнитель"></v-autocomplete>
               </v-card-text>    
            </v-card>
         </v-col>
      </v-row>
      <v-row>
          <v-col cols="12" md="8">
            
      <v-card elevation="2"  class="mx-auto "  outlined>
        <v-row>
           <v-col cols="12" md="6">
         <v-card-text>
             <v-autocomplete item-text="name"  item-value="name"  :items="projects" label="Проект" v-model="data.project_id"></v-autocomplete>
                 
                 </v-card-text>
           </v-col>
           <v-col cols="12" md="6">
          <v-card-title> <v-autocomplete :items="roles"  label="Отдел"  item-text="name"  item-value="id" v-model="data.unit"></v-autocomplete>
         </v-card-title>
           </v-col>
           <v-col cols="12" md="6">
           
            <v-card-title>Файлы</v-card-title>
            <v-card-text>{{data.files}}</v-card-text>
          
         </v-col>
        </v-row>
        
            
      
      </v-card>
         </v-col>
         <v-col cols="12" md="4">
            <v-card elevation="2" class="mx-auto"  outlined>
               <v-card-text>
                     <v-text-field readonly label="Дата создания" outlined color="#4A148C" v-model="this.data.created_at"></v-text-field>
                </v-card-text>
               
                    <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="20" transition="scale-transition" offset-y min-width="300px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="data.end" label="Дата завершения" prepend-icon="event" readonly v-bind="attrs" v-on="on"></v-text-field>
                        </template>
                        <v-date-picker v-model="data.end" @input="menu = false"></v-date-picker>
                    </v-menu>
                     
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
      classes: [],
      tasks:[],
      users:[],
   
      menu: false,
      modal: false,
     
      menu2: false,
      modal2: false,
      projects: [],
      roles:[],
      data:[],
      statuses:[],
      its:[],
      active: false,
      message: 'hello',
      singleSelect: false,
      items2:['Завершить', 'Перенести срок','4'],
 
    }
   
  },
   methods: {
    hoverOver() {        
         this.active =true;
         this.message= 'Добавить проект';
    },
    hoverOut() {     
    },
    
   showInfo() {       
        /*  let params = {id: this.datass.id} */
         axios.get('/tasks/show/'+ this.id).then(response => {
            console.log(response)
            this.data = response.data
         
            
         });

         
      },
      update(){
          axios.post('/tasks/edit/'+this.id,{
         name: this.data.name,
          status_id:this.data.status_id,
          executor_uid:this.data.executor_uid,
          co_executor_uid:this.data.co_executor_uid,
          description:this.data.description,
          owner_uid:this.data.owner_uid,
          project_id:this.data.project_id,
          files:this.data.files,
          unit: this.data.unit,
          end: this.data.end
          }).then(response=>{
             console.log(response)
         }
         );

      },
      destroy(){
          axios.post('/tasks/delete/'+this.id,{
              

          }).then(response => {console.log(response);});

      },
       getUsers() {        
         let params = {}       
         axios.get('/users').then(response => {          
            this.datas = response.data
            this.users = response.data.users;        
            console.log(response)
         });
      },
      getStatuses(){
          axios.get('/statuses').then(response => {          
            this.statuses = response.data.statuses;        
            console.log(response)
         });

      },
     
      getProjects(){
           axios.get('/projects').then(response => {          
            this.projects = response.data.projects;        
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
      
       this.showInfo();
       this.getUsers();
       this.getStatuses();
       this.getProjects();
      
       }    
    
    
}
</script>