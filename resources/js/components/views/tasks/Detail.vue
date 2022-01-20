<template>
   <v-container  fluid >
      <v-card color="#4A148C">   
      <v-card class="mx-auto">
         <v-toolbar color="#27263D" dark>
            <v-col cols="12" md="11"> 
               <v-toolbar-title >{{this.data.name}}</v-toolbar-title> 
            </v-col>  
            <v-col cols="12" md="2">  
                <v-tooltip top>
        <template v-slot:activator="{ on, attrs }">
          
           <router-link :to="{ name: 'tasks_edit'}">                
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
               
            </v-col>
         </v-toolbar>
      </v-card>
      <v-dialog v-model="dialog" width="800px">
         <v-card class="mx-auto">
            <v-card-title> Удалить комментарии?</v-card-title>
            <v-card-text>
               <v-btn @click="deleteComment()">Да</v-btn><v-btn @click="dialog=false">Нет</v-btn>
            </v-card-text>
         </v-card>
      </v-dialog>
      <v-row>
         <v-col cols="12" md="8">       
            <v-card  class="mx-auto" outlined>
               <v-card-text>
                  <v-text-field readonly label="Описание" outlined color="#4A148C" v-model="this.data.description"></v-text-field>
               </v-card-text>
          <v-card-title>
              <span v-if="this.data.status_id===1"><v-alert type="info" small dense>В работе</v-alert></span>
              <span v-if="this.data.status_id===2"><v-alert type="info" small dense>Новый</v-alert></span>
              <span v-if="this.data.status_id===3"><v-alert type="success" small dense>Завершено</v-alert></span>
         </v-card-title>

      </v-card>
         </v-col>
         <v-col cols="12" md="4">
            <v-card  class="mx-auto"  outlined>
               <v-card-text>
              
                     <v-text-field readonly label="Исполнитель" outlined color="#4A148C" v-model="this.data.executor_uid"></v-text-field>
               </v-card-text>
               <v-card-text>
                     <v-text-field readonly label="Соисполнитель" outlined color="#4A148C" v-model="this.data.co_executor_uid"></v-text-field>
               </v-card-text>
                 
            </v-card>
         </v-col>
      </v-row>
      <v-row>
          <v-col cols="12" md="8">
            
      <v-card  class="mx-auto "  outlined>
        <v-row>
           <v-col cols="12" md="6">
         <v-card-text><v-text-field readonly label="Проект" outlined color="#4A148C" v-model="this.data.project_id"></v-text-field>
                 
                 </v-card-text>
           </v-col>
           <v-col cols="12" md="6">
          <v-card-title> <v-text-field readonly label="Отдел" outlined color="#4A148C" v-model="this.data.unit"></v-text-field>
         </v-card-title>
           </v-col>
           <v-col cols="12" md="6">
           
            <v-card-title>Файлы</v-card-title>
              <!--  <v-card-text><a :href="'/storage/uploads/'+this.data.files" target="_blank" v-if="this.data.files != ''">
                                       <img :src="'/storage/uploads/'+this.data.files" width="60">
                                    </a>}
               </v-card-text> -->
          
         </v-col>
        </v-row>

      </v-card>
         </v-col>
         <v-col cols="12" md="4">
            <v-card class="mx-auto"  outlined>
               <v-card-text>
                     <v-text-field readonly label="Дата создания" outlined color="#4A148C" v-model="this.data.created_at"></v-text-field>
                </v-card-text>
                <v-card-text>
                     <v-text-field readonly label="Дата завершения" outlined color="#4A148C" v-model="this.data.end"></v-text-field>
                  </v-card-text>
            </v-card>
         </v-col>     
      </v-row>
      <v-row>
         <v-col >
         <v-card   class="mx-auto"  outlined>
                  <v-card-title>
                     Комментарии к задаче
                  </v-card-title>                                          
            <v-row v-for="items in allcomments" :key="items.id">
               <!-- <div v-if="items.task_id==this.id"> -->
               <v-col cols="12" md="8">
               <v-card  class="mx-auto" outlined height="120">
                  <v-row>
                     <v-col cols="12" md="1"></v-col>
                     <v-col cols="12" md="4">
                       <a> {{items.user.firstname}} {{items.user.lastname}}</a>
                      
                     </v-col>
                     <v-col cols="12" md="6">
                       
                       <a> {{items.created_at}}</a>
                      <!--  {{$moment(parseInt(item.total)).utc().format('HH:mm:ss')}} -->
                     </v-col>
                     <v-col cols="12" md="1">
                         <v-tooltip top>
                           <template v-slot:activator="{ on, attrs }">
                              <v-icon v-bind="attrs" v-on="on" @click="dialog=true" color="#4A148C">mdi-delete-outline</v-icon> </template>
                                 <span>Удалить</span>
                         </v-tooltip>
                     </v-col>
                  </v-row>
                  <v-row>
                     <v-col cols="12" md="12">
                        <v-alert text color="black"> {{items.comment}}</v-alert>
                       <!-- <v-text-field readonly outlined v-model="items.comment">  </v-text-field> -->
                      
                     </v-col>
                  </v-row>
               </v-card>
               </v-col>
               
            </v-row>
            <v-divider></v-divider>
            
         <v-row>           
         <v-col cols="12" md="4">
            <v-card-text>
               <textarea class="input" placeholder="Напишите текст комментарии..." v-model="comments.comment" color="#4A148C" outlined></textarea>
            </v-card-text>                              
         </v-col>
         <v-col cols="12" md="6">
            <v-card-text>
               <v-btn @click="addComment()" dark color="#4A148C"> Добавить комментарии</v-btn>
            </v-card-text>
         </v-col>
            </v-row>
         </v-card>
         </v-col>
      </v-row>   
      </v-card>  
   </v-container>   
</template>
<script>
export default {
   props: ['id', 'task_id'],
    data() {
      return {  
      classes: [],
      tasks:[],
      dialog:false,
      users:[],
      user: auth.user,
      comments:{},
      allcomments:[],
      data:[],
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
       getUsers() {        
         let params = {}       
         axios.get('/users').then(response => {          
            this.datas = response.data
            this.users = response.data.users;        
            console.log(response)
         });
      },
      addComment(){
          axios.put('/create_comment',{
             comment: this.comments.comment,
             user_id: this.user.id,
             users_name: this.user.firstname,
             /* users_name: this.comments.users_name, */
             task_id: this.data.id
          }).then(response => {                              
            console.log(response)
         });
      },
      getComments(){
         axios.get('/comments').then(response => {
            this.allcomments = response.data.comments
            console.log(response)
         });
      },
      deleteComment(){
       /* let params = {id2: this.allcomments.id} */
         axios.post('/comments/delete/'+this.id,{}).then(
            response=>{console.log(response);
         });
      }
   },
    mounted(){
       this.showInfo();
       this.getUsers();
       this.getComments();
     
       }    
}
</script>