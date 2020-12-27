<template>
    <h1>{{ model.data.title }}</h1>

    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input id="title" v-model="model.data.title" class="form-control" name="title" type="text"/>
    </div>

    <h2>Actions</h2>

    <router-view></router-view>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">Name</th>
            <th>Title</th>
            <th class="narrow">Edit</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="v in model.data.actions">
            <td>{{ v.name }}</td>
            <td>{{ v.description }}</td>
            <td>
                <router-link :to="{ name: 'image-processor.action.edit', params: {actionId: v.id}}" class="nav-link">Edit</router-link>
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
            dataGetUrl: '/api/image-processor/' + this.$route.params.id,
        };
    },
    methods: {

    }
}
</script>
