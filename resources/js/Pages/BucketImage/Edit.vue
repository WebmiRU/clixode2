<template>
    <h1>{{ model.data.title }}</h1>

    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input id="title" v-model="model.data.title" class="form-control" name="title" type="text"/>
    </div>

    <div class="mb-3">
        <label class="btn btn-success">
            Upload image
            <input ref="upload_image" @change="uploadImage()" multiple name="file" type="file" accept="image/*" style="display: none"/>
        </label>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Name</th>
            <th>Size</th>
            <th>MIME type</th>
            <th>Link</th>
            <th class="narrow">Edit</th>
            <th class="narrow">Delete</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="v in model.data.images">
            <template v-if="v.id">
                <td>{{ v.id }}</td>
                <td>{{ v.name }}</td>
                <td>{{ v.image.size }}</td>
                <td>{{ v.image.mime_type }}</td>
                <td>
                    <a href="#">Download</a>
                </td>
                <td>
                    <a class="btn btn-warning" href="#">Edit</a>
                </td>
                <td>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </td>
            </template>
            <template v-else>
                <td colspan="7">
                    <progress :value="v.progress" max="100">{{v.progress}}</progress>
                </td>
            </template>
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
            dataGetUrl: '/api/bucket-image/' + this.$route.params.id,
            dataUploadFileUrl: '/api/image',
            model: {data: {files: [], images: []}},
        };
    },
    methods: {
        uploadImage() {
            let image = this.$refs.upload_image.files[0];

            this.upload(image, 'image', this.model.data.images, {bucket_id: this.$route.params.id});
        }
    }
}
</script>
