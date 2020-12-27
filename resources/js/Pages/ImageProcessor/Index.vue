<template>
    <h1>Image processor index</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Title</th>
            <th class="narrow">Edit</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="v in model.data">
            <td>{{ v.id }}</td>
            <td>{{ v.title }}</td>
            <td>
                <router-link :to="{ name: 'image-processor.edit', params: {id: v.id}}" class="nav-link">Edit</router-link>
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
            dataGetUrl: '/api/image-processor',
        };
    },
}
</script>
