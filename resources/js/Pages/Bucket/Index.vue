<template>
    <h1>Bucket index</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Title</th>
            <th>Type</th>
            <th>
                <router-link :to="{ name: 'bucket-file.edit', params: {id: 'create'}}" class="nav-link">Add bucket file</router-link>
                <router-link :to="{ name: 'bucket-image.edit', params: {id: 'create'}}" class="nav-link">Add bucket image</router-link>
            </th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="v in model.data">
            <td>{{ v.id }}</td>
            <td>{{ v.title }}</td>
            <td>{{ v.type }}</td>
            <td>
                <router-link v-if="v.type == 'FILE'" :to="{ name: 'bucket-file.edit', params: {id: v.id}}" class="nav-link">Edit</router-link>
                <router-link v-if="v.type == 'IMAGE'" :to="{ name: 'bucket-image.edit', params: {id: v.id}}" class="nav-link">Edit</router-link>
            </td>
        </tr>

        </tbody>
    </table>
</template>

<script>
import GetData from "../../Mixins/Data";

export default {
    mixins: [GetData],
    data() {
        return {
            dataGetUrl: '/api/bucket',
        };
    },
}
</script>
