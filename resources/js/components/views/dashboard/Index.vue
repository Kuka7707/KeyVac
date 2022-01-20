<template>
<v-container fluid>
  <v-card>
         <v-toolbar color="#27263D" dark>
            <v-toolbar-title><strong>Доска</strong></v-toolbar-title>
               <v-spacer></v-spacer>            
            </v-toolbar>
      </v-card>
 <v-card>
      <v-tabs color="deep-purple accent-4" right>
        <v-tab><strong>Проекты</strong></v-tab>
        <v-tab><strong>Статусы</strong></v-tab> 
        <v-tab-item v-for="n in 1" :key="n">
          <v-container fluid>   
    <v-row>
      <v-col  v-for="item in projects"
                :key="item"
                cols="12"
                md="4">
                <v-card>
                  <v-row>
                   <v-container text-center>
                <router-link :to="{name:'project_show', params: {id:item.id}}" ><h4><a href="#">{{item.name}}</a></h4></router-link>
                <v-alert border="bottom" colored-border color="deep-purple accent-4">{{item.description}}</v-alert>           
                  </v-container>
                  </v-row>
                  <v-row v-for="items in tasks" :key="items">
                    <v-container text-center>
                <router-link :to="{name:'tasks_show', params: {id:items.id}}"><h4><a href="#">{{items.name}}</a></h4></router-link>
                         
                  </v-container>

                  </v-row>
                  <v-divider></v-divider>
                </v-card>
         </v-col> 
    </v-row>
    
          </v-container>
        </v-tab-item>
        <v-tab-item  v-for="n in 1" :key="n">      
          <v-container >
            <v-row>
            <v-col cols="12"
                md="4">
          <v-card text-center>
         <v-toolbar color="#64B5F6">
            <v-toolbar-title><strong>Новый</strong></v-toolbar-title>            
            </v-toolbar>          
          <draggable v-model="news" axis='x'>
    <transition-group>
            <div v-for="item in news" :key="item.id">   
                <v-card color="#E3F2FD">
                   <v-container>
                <h4>{{item.name}}</h4>
                <p>{{item.description}}</p>           
                  </v-container>
                  <v-divider></v-divider>
                  
                </v-card>
            </div>  
    </transition-group>
          </draggable>        
      </v-card>
            </v-col>
      <v-col cols="12"
                md="4">
      
          <v-card text-center>
         <v-toolbar color="#FFB300" centre >
            <v-toolbar-title><strong>В процессе</strong></v-toolbar-title>
               <v-spacer></v-spacer>            
            </v-toolbar>
            <draggable v-model="doing" axis='x'>
    <transition-group>
            <div v-for="item in doing" :key="item.id">   
              <v-card>
                <h4>{{item.name}}</h4>
                <p>{{item.description}}</p>
              </v-card> 
            </div>  
    </transition-group>
          </draggable>
      </v-card>
      
      </v-col>
      <v-col cols="12"
                md="4">
   
          <v-card text-center>
         <v-toolbar color="#66BB6A" text-center>
            <v-toolbar-title><strong>Завершено</strong></v-toolbar-title>
               <v-spacer></v-spacer>            
            </v-toolbar>
           <draggable v-model="done" axis='x'>
    <transition-group>
            <div v-for="item in done" :key="item.id">   
              <v-card>
                <a href="#"><h4>{{item.name}}</h4></a>
                <p>{{item.description}}</p>
              </v-card> 
            </div>  
    </transition-group>
          </draggable>
      </v-card>
        
      </v-col>
            </v-row>
          </v-container>
          

        </v-tab-item>
      </v-tabs>
    </v-card>  
</v-container>

</template>
<script>
import draggable from "vuedraggable";

export default {
  props: ['id'],
    name: "App",

  components: {
   
    draggable
  },
  data() {
    return {
        projects:[],
        news: [],
        doing:[],
        done:[],
        tasks:[],
        statuses:[]
    
    };
  }
  ,methods:{
    getResults() {             
         axios.get('/projects').then(response => {          
            this.projects = response.data.projects;  
            this.news = response.data.new
            this.doing = response.data.doing
            this.done = response.data.done
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
      

      
  },
  mounted(){
      this.getResults();
      this.getTasks();
      
  }   
}
</script>
<style scoped>
.column-width {
  min-width: 320px;
  width: 320px;
}

.ghost-card {
  opacity: 0.5;
  background: #F7FAFC;
  border: 1px solid #4299e1;
}
</style>
