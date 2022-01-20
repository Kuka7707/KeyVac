<template>
   <v-app>

      <navigation v-if="authenticated"/>

      <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="#27263D" dark v-if="authenticated">
         <v-toolbar-title style="width: 300px" class="ml-0 pl-4" >
            <span class="hidden-sm-and-down">Key'Vac</span>
         </v-toolbar-title>
         <!-- <v-text-field flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Search" class="hidden-sm-and-down" ></v-text-field> -->
         <v-spacer></v-spacer>
         <v-btn icon><v-icon>mdi-bell</v-icon></v-btn>
         <v-btn icon @click="logout"><v-icon>mdi-logout</v-icon></v-btn>
      </v-app-bar>


      <div id="main-content" :style="authenticated ? 'margin-left:256px' : '' ">
         <v-container class="fill-height" fluid>
            <router-view />
         </v-container>
      </div>



      <v-dialog v-model="dialog" width="800px" v-if="authenticated">
         <v-card>
            <v-card-title class="grey darken-2">
               Create contact
            </v-card-title>
            <v-container>
               <v-row class="mx-2">
                  <v-col class="align-center justify-space-between" cols="12">
                     <v-row align="center" class="mr-0">
                        <v-avatar size="40px" class="mx-3">
                           <img src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png" alt="">
                        </v-avatar>
                        <v-text-field placeholder="Name"></v-text-field>
                     </v-row>
                  </v-col>
                  <v-col cols="6">
                     <v-text-field prepend-icon="mdi-account-card-details-outline" placeholder="Company"></v-text-field>
                  </v-col>
                  <v-col cols="6">
                     <v-text-field placeholder="Job title"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                     <v-text-field prepend-icon="mdi-mail" placeholder="Email"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                     <v-text-field type="tel" prepend-icon="mdi-phone" placeholder="(000) 000 - 0000"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                     <v-text-field prepend-icon="mdi-text" placeholder="Notes"></v-text-field>
                  </v-col>
               </v-row>
            </v-container>
            <v-card-actions>
               <v-btn text color="primary">More</v-btn>
               <v-spacer></v-spacer>
               <v-btn text color="primary" @click="dialog = false">Cancel</v-btn>
               <v-btn text @click="dialog = false">Save</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-app>

</template>

<script>

import MainNavigation from './Menu/MainMenu.vue'

export default {
   components:{
      "navigation": MainNavigation
   },
   props: {
      source: String,
   },
   data: () => ({
      dialog: false,
      authenticated: auth.check(),
      user: auth.user,
   }),


   methods:{
      logout(){
         auth.logout()
         this.authenticated = false
      },

      changeDialog: function () {
         this.dialog = !this.dialog
      },


   },

   mounted(){
      Event.$on('userLoggedIn', () => {
         this.authenticated = true;
      });

      Event.$on('userLoggedOut', () => {
         this.authenticated = false;
         this.$router.push('/login');
      });

   }
}
</script>

<style>
#main-content{
   margin-top: 64px;
   transition: .3s;
   /* margin-left: 256px; */
}

.v-navigation-drawer{
   top: 64px!important;
}
</style>
