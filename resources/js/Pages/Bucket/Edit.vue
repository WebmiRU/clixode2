<template>
    <h1>{{ model.data.title }}</h1>

    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input id="title" v-model="model.data.title" class="form-control" name="title" type="text"/>
    </div>

    {{fileUploads}}

    <div class="mb-3">
        <label class="btn btn-success">
            Upload file
            <input ref="upload_file" @change="uploadFile()" multiple name="file" type="file" style="display: none"/>
        </label>
<!--{{uploadFileByLink()}}-->
        <button class="btn btn-success" @click="uploadFileByLink()">Upload by link12</button>
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

        <tr v-for="v in model.data.files">
            <template v-if="v.id">
                <td>{{ v.id }}</td>
                <td>{{ v.name }}</td>
                <td>{{ v.file.size }}</td>
                <td>{{ v.file.mime_type }}</td>
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

    <ul>
        <!--        @foreach($model->images as $v)-->
        <!--        <li>{{$v->id}} / {{$v->image->sha256}}</li>-->
        <!--        @endforeach-->
    </ul>
</template>

<script>
import GetData from "../../Mixins/Data";

export default {
    mixins: [GetData],
    data() {
        return {
            dataGetUrl: '/api/bucket/' + this.$route.params.id,
            model: {data: {files: [], images: []}},
        };
    },
    methods: {
        uploadFile() {
            let file = this.$refs.upload_file.files[0];

            console.log(file);
            console.log(111, this.model.data.files);
            console.log({bucket_id: this.$route.params.id});

            this.upload(file, 'file', this.model.data.files, {bucket_id: this.$route.params.id});
        },
        uploadFileByLink() {
            // this.model.data.files.append();
            this.uploadByLink({bucket_id: this.$route.params.id, url: 'https://speed.hetzner.de/100MB.bin'});
        }
    }
}
</script>
