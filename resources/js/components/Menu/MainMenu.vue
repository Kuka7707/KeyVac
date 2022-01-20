<template>
   <div>
      <v-navigation-drawer :clipped="$vuetify.breakpoint.lgAndUp" app>
         <v-list dense>
            <template v-for="item in items">
               <v-row v-if="item.heading" :key="item.heading" align="center">
                  <v-col cols="6">
                     <v-subheader v-if="item.heading">
                        {{ item.heading }}
                     </v-subheader>
                  </v-col>
                  <v-col cols="6" class="text-center">
                     <a href="#!" class="body-2 black--text">EDIT</a>
                  </v-col>
               </v-row>
               <v-list-group v-else-if="item.children" :key="item.text" v-model="item.model" :prepend-icon="item.model ? item.icon : item['icon-alt']" append-icon="">
                  <template v-slot:activator>
                     <v-list-item-content>
                        <v-list-item-title>
                           {{ item.text }}
                        </v-list-item-title>
                     </v-list-item-content>
                  </template>
                  <v-list-item v-for="(child, i) in item.children" :key="i" link>
                     <v-list-item-action v-if="child.icon">
                        <v-icon>{{ child.icon }}</v-icon>
                     </v-list-item-action>
                     <v-list-item-content>
                        <v-list-item-title>
                           {{ child.text }}
                        </v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </v-list-group>

               <div v-else>
                  <router-link :to="item.link">
                     <v-list-item :key="item.text" link>
                        <v-list-item-action>
                           <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                           <v-list-item-title>
                              {{ item.text }}
                           </v-list-item-title>
                        </v-list-item-content>
                     </v-list-item>
                  </router-link>
               </div>
            </template>
         </v-list>
      </v-navigation-drawer>
   </div>
</template>

<script>

export default {

   data(){
      return{
         items: [
            //{
               //icon: 'mdi-clipboard-text-play',
              // text: 'Доска',
               //link:'dashboard'
            //},

            //{
              // icon: 'mdi-file-edit-outline',
              // text: 'Задачи',
              // link:'tasks'
           // },

           // {
             //  icon: 'mdi-signal-cellular-2',
              // text: 'Проекты',
              // link:'projects'
               
           // },
           {
               icon: 'mdi-account-box',
               text: 'Профиль',
               link:'login'
            },
            {
               icon: 'mdi-account-box-multiple',
               text: 'Пользователи',
               link:'users'
            },

            {
               icon: 'mdi-account-cog',
               'icon-alt': 'mdi-account-cog',
               text: 'Управление системой',
               link:'login',
               model: false,
               children: [
                  {
                     icon: 'mdi-chat-alert',
                     text: 'Объявление',
                     link:'login'
                  },
                  {
                     icon: 'mdi-bell-alert',
                     text: 'Уведомление',
                     link:'login'
                  },
                  {
                     icon: 'mdi-atlassian',
                     text: 'Системные переменные',
                     link:'login'
                  },
               ],
            },
            {
               icon: 'mdi-pillar',
               'icon-alt': 'mdi-pillar',
               text: 'Управление учреждением',
               link:'login',
               model: false,
               children: [
                  {
                     icon: 'mdi-bank',
                     text: 'Учреждение',
                     link:'login'
                  },
                  {
                     icon: 'mdi-box-shadow',
                     text: 'Склад',
                     link:'login'
                  },
                  {
                     icon: 'mdi-briefcase-edit',
                     text: 'Партия вакцины на складе',
                     link:'login'
                  },
               ],
            },
            {
               icon: 'mdi-pencil-remove',
               'icon-alt': 'mdi-pencil-remove',
               text: 'Управление вакцинами',
               link:'login',
               model: false,
               children: [
                  {
                     icon: 'mdi-pencil',
                     text: 'Вакцина',
                     link:'login'
                  },
                  {
                     icon: 'mdi-bulletin-board',
                     text: 'Информация о дозах вакцины',
                     link:'login'
                  },
                  {
                     icon: 'mdi-calendar-check',
                     text: 'Правила вакцинации',
                     link:'login'
                  },
                  {
                     icon: 'mdi-calendar-multiselect',
                     text: 'Предварительное планирование',
                     link:'login'
                  },
               ],
            },
            {
               icon: 'mdi-settings',
               'icon-alt': 'mdi-settings',
               text: 'Параметры',
               link:'login',
               model: false,
               children: [
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Страна',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Город',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Район',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Тип учреждения',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Вид учреждения',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Произодитель вакцины',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Часть тела, куда ставится вакцина',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Техника введения вакцины',
                     link:'login'
                  },
                  {
                     icon: 'mdi-arrow-right',
                     text: 'Причина удаления вакцинации',
                     link:'login'
                  },
               ],
            },
            //{
               //icon: 'mdi-alpha',
               //text: '1430.kz',
               //link:'login'
           // },

            //{
               //icon: 'mdi-antenna',
               //text: 'Оборудование и сервера',
               //link:'login',
            //},

            

            {
               icon: 'mdi-account-group-outline',
               text: 'Группы пользователей',
               link:'roles'
            },
            
         ],
      }
   },



}
</script>


<style>
.v-list-group__items .v-list-item{
   margin-left: 15px;
}

.v-navigation-drawer{
   transform: translateX(0)!important;
   visibility: visible!important;
}
</style>
