<template>
    <h1>{{ model.data.title }}</h1>

    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input id="title" v-model="model.data.title" class="form-control" name="title" type="text"/>
    </div>

    <h2>Actions</h2>

    <template v-if="actionIdx >= 0">
        <h4>Action edit {{actionIdx}}</h4>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="narrow">Name</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="v in model.data.actions[actionIdx].params">
                <td>{{ v.name }}</td>
                <td>
                    <input type="text" v-model="v.value" class="form-control" />
                </td>
            </tr>

            </tbody>
        </table>

        <button @click="actionIdx = -1" class="btn btn-success">OK</button>
    </template>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">Name</th>
            <th>Title</th>
            <th class="narrow">Edit</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(v, idx) in model.data.actions">
            <td>{{ v.name }}</td>
            <td>{{ v.description }}</td>
            <td>
                <button @click="actionIdx = idx" class="btn btn-warning">Edit</button>
            </td>
        </tr>

        </tbody>
    </table>

    <button @click="submit" class="btn btn-success">Update</button>
</template>

<script>
import GetData from "../../Mixins/Data";
import Button from "@/Jetstream/Button";

export default {
    components: {Button},
    mixins: [GetData],
    data() {
        return {
            dataUrl: '/api/image-processor',
            actionIdx: -1,
        };
    },
    methods: {

    }
}
</script>
