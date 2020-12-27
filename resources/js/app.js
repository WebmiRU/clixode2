import {createApp} from 'vue'
import {createRouter, createWebHistory, createWebHashHistory} from "vue-router";

import Index from './Pages/Index'
import BucketIndex from './Pages/Bucket/Index'
import BucketEdit from './Pages/Bucket/Edit'
import BucketImageEdit from './Pages/BucketImage/Edit'
import ImageProcessorIndex from './Pages/ImageProcessor/Index'
import ImageProcessorEdit from './Pages/ImageProcessor/Edit'

const routes = [
    {path: '/bucket', name: 'bucket.index', component: BucketIndex},
    {path: '/bucket/:id', name: 'bucket.edit', component: BucketEdit},
    {path: '/bucket-image/:id', name: 'bucket-image.edit', component: BucketImageEdit},
    {path: '/image-processor', name: 'image-processor.index', component: ImageProcessorIndex},
    {path: '/image-processor/:id', name: 'image-processor.edit', component: ImageProcessorEdit},
];

const router = createRouter({
    history: createWebHashHistory(),
    // history: createWebHistory(),
    routes,
});

const app = createApp(Index);
app.use(router);
app.mount('#app');
// app.component('app-version-edit', AppVersionEdit);
