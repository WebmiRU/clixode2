import {createApp} from 'vue'
import {createRouter, createWebHistory, createWebHashHistory} from "vue-router";
// import router from './router' // <---
import Index from './Pages/Index'
import BucketImageEdit from './Pages/BucketImage/Edit'

const routes = [
    {path: '/bucket-image/:id', name: 'bucket-image.edit', component: BucketImageEdit},
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

const app = createApp(Index);
app.use(router);
app.mount('#app');
// app.component('app-version-edit', AppVersionEdit);
