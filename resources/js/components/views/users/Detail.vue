<template>
     <v-card class="mx-auto"  outlined>
            
              <v-card-text class="text-center">
                <h3 class="headline mb-2">
                  {{data.firstname}} {{data.lastname}}
                </h3>
                <div class="blue--text mb-2">
                  {{data.name}}
                </div>
                <div class="blue--text subheading font-weight-bold">
                  {{data.role}}
                </div>
              </v-card-text>
              <v-divider></v-divider>
              <v-row
                class="text-left"
                tag="v-card-text">
                <v-col
                  class="text-right mr-4 mb-2"
                  tag="strong"
                  cols="5">
                  Email:
                </v-col>
                <v-col>{{data.email}}</v-col>
                <v-col
                  class="text-right mr-4 mb-2"
                  tag="strong"
                  cols="5">
                  Phone:
                </v-col>
                <v-col>
                  <a>{{data.phone}}</a>
                </v-col>
                <v-col
                  class="text-right mr-4 mb-2"
                  tag="strong"
                  cols="5">
                  Status:
                </v-col>
                <v-col>
                  <span v-if="data.status==='1'">Активный</span>
                  <span v-else>Не активный</span>
                    </v-col>
                <v-col> <router-link :to="{ name: 'users_edit'}"><v-btn dark color="#4A148C">Изменить</v-btn></router-link></v-col>
              </v-row>
            </v-card>
          
</template>
<script>
export default {
    props: ['id'],
    data() {
      return {  
          data:[]
      
    }  
  },
   methods: {
   
   showInfo() {       
        
         axios.get('/users/show/'+ this.id).then(response => {
            console.log(response)
            this.data = response.data.user
         });
      }
       
   },
    mounted(){
       this.showInfo();    
       }    
    
}
</script>