<template>
      <v-container class="pr-7" fluid align="center" >  
         <v-card  max-width="1000">
            <v-row>
               <v-col cols="12" md="6">
                  <v-col cols="12" md="12"><h4>Новый проект</h4></v-col>
               </v-col>
               <v-col cols="12" md="6" class="text-right">
                 <v-col> <router-link to="/projects"><v-btn class="primary" @click="addNewProject()" >Добавить</v-btn></router-link>
               <router-link to="/projects">  <v-btn class="error" >Закрыть</v-btn></router-link></v-col>                
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
                              <!-- <input type="checkbox" :value="item.firstname" v-model="selected"> -->
                              <input type="checkbox" value="item.firstname" name="selected"> 
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
                  <v-btn @click="dialog = false">Добавить</v-btn>
                  <v-btn color="green darken-1" text @click="dialog = false" >Закрыть</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
            <v-form>
              <v-row>
               <v-col cols="12" md="6">
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-text-field label="Название проекта" outlined color="#4A148C" dense v-model="projects.name"></v-text-field></v-col>
                        </v-col>                       
                     </v-row>
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-textarea label="Описание проекта" outlined dense v-model="projects.description"></v-textarea></v-col>
                        </v-col>                        
                     </v-row>      
                     <v-row>
                        <v-col cols="12" md="12">
                           <v-col><v-select label="Статус" outlined dense item-text="name"  item-value="id" :items="status" v-model="projects.status"></v-select></v-col>
                        </v-col>                        
                     </v-row>     
               </v-col>
            </v-row>            
         </v-form>
  <v-row>
                 <v-col cols="12" sm="8">
                     <v-expansion-panels elevation="5">
      <v-expansion-panel>
        <v-expansion-panel-header v-slot="{ open }">
          <v-row no-gutters>
            <v-col cols="12" md="4">
              Срок проекта
            </v-col>
            <v-col
              cols="12" md="6"
              class="text--secondary">
              <v-fade-transition leave-absolute>
                <span v-if="open"></span>
                <v-row
                  v-else
                  no-gutters  >
                  <v-col cols="12" md="6"> 
                    Начало: {{ projects.start || '' }}
                  </v-col>
                  <v-col cols="12" md="6">
                    Конец: {{ projects.end || '' }}
                  </v-col>
                </v-row>
              </v-fade-transition>
            </v-col>
          </v-row>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <v-row
            justify="space-around"
            no-gutters
          >
            <v-col cols="12" md="6">
              <v-menu
                ref="startMenu"
                :close-on-content-click="false"
                :return-value.sync="projects.start"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="projects.start"
                    label="Начало"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="date"
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.startMenu.isActive = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.startMenu.save(date)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" md="6">
              <v-menu
                ref="endMenu"
                :close-on-content-click="false"
                :return-value.sync="projects.end"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="projects.end"
                    label="Конец"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="date"
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.endMenu.isActive = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.endMenu.save(date)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-row>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
                 </v-col>
            </v-row>
            <v-divider/>
                    <v-card>
                      <v-row>
                        <v-col cols="12" md="4">
                           <v-col><v-select label="Выбрать руководителя" outlined dense v-model="projects.admin" :items="users" item-text="firstname" item-value="id" ></v-select></v-col>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-col> <span>Участники проекта: {{selected}}</span> </v-col>
                           <v-col>
                              <v-btn @click="dialog =!dialog" small color="#4A148C" dark>Добавить участников</v-btn> </v-col></v-col>
                     </v-row>                     
            </v-card>
         </v-card>
      </v-container>
</template>
<script>
export default {
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
         project:{},
         checkedNames: [],
         date: null,
         projects:[],
         firsstname:[],
         datas: [],
         trip: {
            name: '',
            location: null,
            start: null,
            end: null,
          },
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
      addNewProject(){
        axios.put('/create_project',{
          name: this.projects.name,
          status: this.projects.status,
          description: this.projects.description,
          admin: this.projects.admin,
          participants: this.selected
          /* id: this.projects.id */
            
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
      getInfo(){
        axios.get('/projects').then(response => {          
            
            this.status = response.data.status;        
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
    }
   },
   mounted(){
       this.getResults();
       this.addNewUser();
       this.getInfo();
   }
}
</script>
