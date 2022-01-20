<template>
   <v-container  fluid>
      <v-card>
         <v-toolbar color="#27263D" dark>
            <v-toolbar-title><strong>Проекты</strong></v-toolbar-title>
               <v-spacer></v-spacer>
               <v-tooltip top>
        <template v-slot:activator="{ on, attrs }">
                     
                  <v-btn 
            v-bind="attrs"
            v-on="on" class="mx-2" @click="create=true" small fab dark color="#27263D">
                     <v-icon large>mdi-plus-circle-outline</v-icon>
                  </v-btn>       
        </template>
        <span>Создать новый проект</span>
               </v-tooltip>
            </v-toolbar>
      </v-card>
      <v-dialog v-model="create" max-width="1000">
           <v-card >
            <v-row>
               <v-col cols="12" md="6">
                  <v-col cols="12" md="12"><h4>Новый проект</h4></v-col>
               </v-col>
               <v-col cols="12" md="6" class="text-right">
                 <v-col> <router-link to="/projects"><v-btn class="primary" @click="addNewProject()" >Добавить</v-btn></router-link>
               <router-link to="/projects">  <v-btn class="error" @click="create=!create">Закрыть</v-btn></router-link></v-col>                
               </v-col>
            </v-row>
            <v-dialog v-model="dialog4" max-width="600">
            <v-card >
               <v-card-title class="headline">Выберите участников</v-card-title>
               <v-card-text>
                <v-simple-table class="table table-striped table-hover">
		                <thead>
                      <tr>
                        <th>
                          <label class="form-checkbox">
                            <input type="checkbox" v-model="selectAll" @click="select">
                            <i class="form-icon"></i>
                          </label>
                        </th>
                        <th>id</th>
                        <th>Имя</th>                      
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,i) in users" :key="i">
                        <td>
                          <label class="form-checkbox">
                              <input type="checkbox" :value="item.firstname" v-model="selected">
                            <i class="form-icon"></i>
                            </label>
                        </td>
                        <td>  {{item.id}}  </td>
                        <td>  {{item.firstname}}  </td>                      
                      </tr>                     
                    </tbody> 
                  </v-simple-table>                 
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn @click="dialog4 = false">Добавить</v-btn>
                  <v-btn color="green darken-1" text @click="dialog4 =! dialog4" >Закрыть</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
            <v-form>
              <v-row>
               <v-col cols="12" md="6">
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-text-field label="Название проекта" outlined color="#4A148C" dense v-model="projects2.name"></v-text-field></v-col>
                        </v-col>                       
                     </v-row>
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-textarea label="Описание проекта" outlined dense v-model="projects2.description"></v-textarea></v-col>
                        </v-col>                        
                     </v-row>   
                      
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-select label="Статус" outlined dense item-text="name"  item-value="id" :items="status" v-model="projects2.status"></v-select></v-col>
                        </v-col>                        
                     </v-row>     
               </v-col>
            </v-row>            
         </v-form>
 
            <v-divider/>
                    <v-card>
                      <v-row>
                        <v-col cols="12" md="4">
                           <v-col><v-select label="Выбрать руководителя" outlined dense v-model="projects2.admin" :items="users" item-text="firstname" item-value="id" ></v-select></v-col>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-col> <span>Участники проекта: {{selected}}</span> </v-col>
                           <v-col>
                              <v-btn @click="dialog4 =! dialog4" small color="#4A148C" dark>Добавить участников</v-btn> </v-col></v-col>
                        
                       
                     </v-row>
                     
                                 
            </v-card>
         </v-card>
         </v-dialog>
       <v-dialog v-model="dialog" max-width="600">
            <v-card>
               <v-card-title class="headline">Описание проекта</v-card-title>
               <v-card-text>
                
                   <span>{{this.projects.description}}</span>
                   
               
                 
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                 
                  <v-btn color="green darken-1" text @click="dialog=false" >Закрыть</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
          <v-dialog v-model="dialog2" max-width="600">
            <v-card>
               <v-card-title class="headline">Список участников</v-card-title>
               <v-card-text>
                 <div v-for="(item,i) in projects" :key="i">
                   <span>{{item.participants}}</span>
                 </div>
                 
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                 
                  <v-btn color="green darken-1" text @click="dialog2= false" >Закрыть</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
       <v-card>
      <v-tabs color="deep-purple accent-4" right>
        <v-tab><strong>Мои проекты</strong></v-tab>
        <v-tab><strong>На сегодня</strong></v-tab>
        
  
        <v-tab-item v-for="n in 1" :key="n">
          <v-container fluid>
            <v-row>
                <v-col>
                  <v-simple-table class="table table-striped table-hover">
		                <thead>
                      <tr>
                        <!-- <th>
                          <label class="form-checkbox">
                            <input type="checkbox" v-model="selectAll" @click="select">
                            <i class="form-icon"></i>
                          </label>
                        </th> -->
                        <th>id</th>
                        <th>Название</th>
                        <th>Дата создания</th>
                        <th>Статус</th>
                        <th>Описание</th>
                     
                        <th>Руководитель</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, i) in projects" :key="i">
                        <td>  {{item.id}}  </td>
                        <td><router-link :to="{name:'project_show', params: {id:item.id}}" >  <a> {{item.name}} </a></router-link> </td>
                        <td> {{item.created_at}} </td>
                       <td> 
                           <span  v-if="item.status==='1'"> В работе</span>
                        <span  v-else-if="item.status==='2'"> Завершено</span>
                        <span  v-else-if="item.status==='3'"> Новый</span>
                        <span  v-else> {{item.status}}</span>
                            </td>
                        <td>  <v-btn @click="dialog = !dialog" small color="#4A148C" dark>Просмотр </v-btn></td><!-- {{item.description}} -->
                         <td>  
                           <span  v-if="item.admin==='1'"> Ержан</span>
                        <span  v-else-if="item.admin==='4'">Камила</span>
                        <span  v-else> Бахтыбаев Жандос</span>  </td>
                      </tr>                    
                    </tbody>          
                  </v-simple-table>
                  <!-- <div class="text-uppercase text-bold">Выбрано: {{ selected }} 
                    <div v-for="(items,index) in selected" v-if="index>=0">
                   
                     <v-btn small class="ma-2" dark color="#4A148C" @click="destroyProject">Завершить</v-btn></div></div>
                  
          --> </v-col>             
            </v-row>
          </v-container>
        </v-tab-item>
        <v-tab-item  v-for="n in 1" :key="n">
          <v-card>
            <v-card-text>
            <div class="font-weight-bold ml-8 mb-2">
              Задачи на сегодня
            </div>
  
            <v-timeline align-top dense>
              <v-timeline-item
                v-for="message in messages"
                :key="message.time"
                :color="message.color"
                small
              >
                <div>
                  <div class="font-weight-normal">
                    <strong>{{ message.from }}</strong> @{{ message.time }}
                  </div>
                  <div>{{ message.message }}</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
        </v-tab-item>
      </v-tabs>
    </v-card>
    <v-card>
       
    </v-card>
   </v-container>
</template>
<script>
import moment from 'moment';

export default {
  props: ['id'],
   data() {
      return {
      dialog: false,
      dialog2: false,
      dialog4:false,
      create:false,
      active: false,
      users: [],
      classes: [],
      singleSelect: false,
      
    data:[],
    status: [],
    messages: [
      {
        from: 'Kamila',
        message: `Create project`,
        time: '16:00 pm',
        color: 'deep-purple lighten-1',
      },
      {
        from: 'Erzhan',
        message: 'Webphone',
        time: '17:37 pm',
        color: 'green',
      },
      /* {
        from: 'Kamila',
        message: 'Update, delete project',
        time: '18:00 pm',
        color: 'deep-purple lighten-1',
      }, */
    ],
    projects: [],
    projects2:[],
    selected: [],
    description:{},
		selectAll: false
      
    }
   
  },
   methods: {
    hoverOver() {
        /*  
         this.active =true;
         this.message= 'Добавить проект'; */
    },
    hoverOut() {
        
    },
    
    
    getColor (effect) {
      if (effect> 70) return 'red'
      else if (effect > 90) return 'orange'
      else return 'green'
    },
    select() {
			this.selected = [];
			if (!this.selectAll) {
				for (let i in this.projects) {
					this.selected.push(this.projects[i].name);
				}
			}
    },
     getResults() {             
         axios.get('/projects').then(response => {          
            this.data = response.data
            this.projects = response.data.projects;  
            this.status = response.data.status;   
            this.description =Object.values(response.data.projects)    
            console.log(response)
         });
      },
      getUsers(){
         axios.get('/users').then(response => {          
            
            this.users = response.data.users;        
            console.log(response)
         });
      },
      formatDate(value){
        return moment(value).format("MMMM DD YYYY")

      },
       addNewProject(){
        axios.put('/create_project',{
          name: this.projects2.name,
          status: this.projects2.status,
          description: this.projects2.description,
          admin: this.projects2.admin,
          participants: this.selected,
          id: this.projects2.id
            
         }).then(response  => {
            
            console.log(response)
            
           
            this.$notify({
               group: "alert",
               title: 'Успешно',
               type: 'primary',
               text: 'Сохранено',
               duration: 10000
            });
         })
            
            
      },
       /* destroyProject(){
          axios.post('/projects/delete/'+ this.id,{
             
          }).then(response => {
            console.log(response)
            this.$notify({
               group: "alert",
               title: 'Успешно',
               type: 'primary',
               text: 'удалено',
               duration: 10000
            });
         })
       }, */
   },
   mounted(){
       this.getUsers();
       this.getResults(); 
       }
   
}
</script>
<style scoped>
body{
	padding: 50px
}
</style>
