<template>
    <h1>Index page</h1>

    <router-view></router-view>

    <router-link :to="{ name: 'bucket-image.edit', params: { id: '123' }}">Bucket image</router-link>
</template>

<script>
export default {
    name: 'Index'
};
</script>
