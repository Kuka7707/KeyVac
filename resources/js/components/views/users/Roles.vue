<template>

   <v-container class="fill-height" fluid>
      <v-card class="p-4 text-left col-md-12" >
         <v-row>
            <v-col cols="6"><h2>Роли</h2></v-col>
            <v-dialog v-model="dialog" persistent max-width="800px">

               <template v-slot:activator="{ on, attrs }">
                  <v-col cols="6" class="text-right"><v-btn v-bind="attrs" v-on="on"><i class="mdi mdi-account-plus"></i> &nbsp; Добавить</v-btn> </v-col>
               </template>

               <v-card>
                  <v-card-title>
                     <span class="headline">Роль</span>
                  </v-card-title>
                  <v-card-text>
                     <v-container>
                        <v-row>
                           <v-col cols="12">
                              <v-text-field label="Наименование*" required></v-text-field>
                           </v-col>
                           <v-col cols="12">
                              <v-textarea outlined name="input-7-4" label="Описание"></v-textarea>
                           </v-col>

                           <v-col cols="12" sm="6">
                              <v-autocomplete :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']" label="Проект"></v-autocomplete>
                           </v-col>
                           <v-col cols="12" sm="6">
                              <v-autocomplete :items="['Техническая поддержка', 'Административный отдел']" label="Отдел"></v-autocomplete>
                           </v-col>

                           <v-col cols="12" sm="6">
                              <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                 <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="date" label="Дата" prepend-icon="event" readonly v-bind="attrs" v-on="on"></v-text-field>
                                 </template>
                                 <v-date-picker v-model="date" @input="menu = false"></v-date-picker>
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
                     <v-btn color="blue darken-1" text @click="dialog = false">Сохранить</v-btn>
                  </v-card-actions>
               </v-card>
            </v-dialog>
         </v-row>
         <hr>
         <v-simple-table>
            <thead>
               <tr>
                  <th>Наименование</th>
                  <th>Права</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="role in roles">
                  <td>{{role.name}}</td>
                  <td>
                     <span v-for="item in role.permission">
                        <span v-if="item.status == 1">
                           {{ item.name}} |
                        </span>
                     </span>
                  </td>
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
         time: null,
         menu2: false,
         modal2: false,
         files: [],
         roles:[
            {
               name: 'Наименование',
               read: 'Чтение',
               edit: 'Редактирование',
               del: 'Удаление',
            }
         ]
      }
   },
   mounted(){
      axios.get('/roles').then(response => (
         this.roles = response.data
      ))
   }
}
</script>
<style scoped>
img{
   margin-right: 10px;
}
</style>
