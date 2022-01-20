<template>
      <v-container class="pr-7" fluid align="center" >  
         <v-card  max-width="1000">
            <v-row>
               <v-col cols="12" md="6">
                  <v-col cols="12" md="12"><h4>Редактирование проекта</h4></v-col>
               </v-col>
               <v-col cols="12" md="6" class="text-right">
                 <v-col> <!--  <router-link to="/projects"> --> <v-btn class="primary" @click="update()" >Сохранить</v-btn> <!-- </router-link> -->
      <router-link to="/projects"><v-btn class="error" @click="destroyProject()">Удалить</v-btn></router-link>
                 </v-col>                 
               </v-col>
            </v-row>
            <v-dialog v-model="dialog" max-width="600">
            <v-card>
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
                      <tr v-for="item in users">
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
                  <v-btn @click="members()">Добавить</v-btn>
                  <v-btn color="green darken-1" text @click="dialog = false" >Закрыть</v-btn>
                  
               </v-card-actions>
            </v-card>
         </v-dialog>
            <v-form>
              <v-row>
               <v-col cols="12" md="6">
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-text-field label="Название проекта" outlined color="#4A148C" dense v-model="datas.project.name"></v-text-field></v-col>
                        </v-col>                       
                     </v-row>
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-textarea label="Описание проекта" outlined dense color="#4A148C" v-model="datas.project.description"></v-textarea></v-col>
                        </v-col>                        
                     </v-row>                         
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-select label="Статус" outlined dense color="#4A148C" item-text="name"  item-value="id" :items="status" v-model="datas.project.status"></v-select></v-col>
                        </v-col>                        
                     </v-row>     
               </v-col>
            </v-row>            
         </v-form>
  
            <v-divider/>
                    <v-card>
                      <v-row>
                        <v-col cols="12" md="4">
                           <v-col><v-select color="#4A148C" label="Выбрать руководителя" outlined dense v-model="datas.project.admin" :items="users" item-text="firstname" item-value="id" ></v-select></v-col>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-col>
                            <span >Участники проекта:</span>
                            <v-text-field color="#4A148C" v-model="datas.project.participants" outlined label="selected"></v-text-field> 
                          </v-col><!-- v-model="datas.project.participants" -->
                          <v-col>
                              <v-btn @click="dialog=!dialog" small color="#4A148C" dark >Добавить участников</v-btn>
                          </v-col>
                        </v-col>                       
                     </v-row>                      
            </v-card>
         </v-card>
      </v-container>
</template>
<script>
export default {
  props: ['id'],
   data () {
      return {
         show: false,
         dialog: false,
         errors: {},
         data:[],
         status:[],
         selected: [],
		   selectAll: false,
         users: [],
         project:[],
         checkedNames: [],
         date: null,
         projects:[],
         firsstname:[],
         datas: [],
         roles: [],
         institutions: [],
      }
   },
   methods:{
      getResults() {        
         let params = {}       
         axios.get('/users').then(response => {          
            this.data = response.data
            this.users = response.data.users;        
            console.log(response)
         });
      },
      showInfo() {       
        /*  let params = {id: this.datass.id} */
         axios.get('/projects/show/'+ this.id).then(response => {
            console.log(response)            
            this.datas = response.data
         });
      },
      update(){
        axios.post('/projects/edit/'+ this.id,{
             name:this.datas.project.name,
             description: this.datas.project.description,
             status: this.datas.project.status,
             admin: this.datas.project.admin,
            /*  participants:this.selected */
             participants:this.datas.project.participants
          }).then(response => {
            console.log(response)                  
         }).then(response => {
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
      destroyProject(){
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
       },
      getStatuses(){
        axios.get('/statuses').then(response => {          
            this.status= response.data.statuses                  
            console.log(response)
         });
      },
      select() {
			this.selected = [];
			if (!this.selectAll) {
				for (let i in this.users) {
					this.selected.push(this.users[i].firstname);
				}
			}
    },
    members(){
      this.datas.project.participants=this.selected;
    }
   },
   mounted(){
       this.getResults();
       this.showInfo();
       this.getStatuses();
   }
}
</script>
