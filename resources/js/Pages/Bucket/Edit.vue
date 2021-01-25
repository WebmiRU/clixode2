<template>
    <h1>{{ model.data.title }}</h1>

    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input id="title" v-model="model.data.title" class="form-control" name="title" type="text"/>
    </div>

    {{ fileUploads }}

    <div class="mb-3">
        <label class="btn btn-success">
            Upload file
            <input ref="upload_file" @change="uploadFile()" multiple name="file" type="file" style="display: none"/>
        </label>
    </div>

    <div class="mb-3">
        <input ref="upload_url" class="form-control" type="text"/>
    </div>
    <div class="mb-3">
        <button class="btn btn-success" @click="uploadFileByUrl()">Upload by link12</button>
    </div>


    <!--Download tasks -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Url</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="v in model.data.tasks">
            <template v-if="v.id">
                <td>{{ v.id }}</td>
                <td>{{ v.progress }}</td>

                <td colspan="7">
                    <progress :value="v.progress" max="100">{{ v.progress }}</progress>
                </td>
            </template>
        </tr>

        </tbody>
    </table>


    <!--Files-->
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
                    <progress :value="v.progress" max="100">{{ v.progress }}</progress>
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
            model: {data: {files: [], images: [], tasks: []}},
            dataUploadFileUrlByLink: '/api/file/link',
            CheckTaskStatusUrl: '/api/download-task/bucket',
        };
    },
    methods: {
        uploadFile() {
            let file = this.$refs.upload_file.files[0];

            this.upload(file, 'file', this.model.data.files, {bucket_id: this.$route.params.id});
        },
        uploadFileByUrl() {
            let url = this.$refs.upload_url.value;
            this.uploadByUrl({bucket_id: this.$route.params.id, url: url});
        },
        async uploadByUrl(data) {
            let response = await this.request('POST', this.dataUploadFileUrlByLink, data);

            switch (response.type) {
                case 'download_task':
                    console.log(444, this.model.data.tasks);
                    this.model.data.tasks.push(response.data);
                    console.log('uploadByUrl');
                    console.log('dowmload_task');
                    await this.checkStatus();
                    break;
                case 'bucket_file':
                    this.model.data.files.push(response.data);
                    break;
                default:
                    break;
            }
        },
        async checkStatus() {
            // let response = await this.request('GET', this.CheckTaskStatusUrl, {bucket_id: this.$route.params.id}).then(response => {
            let response = await this.request('GET', `${this.CheckTaskStatusUrl}/${this.$route.params.id}`).then(response => {

                let currentTasks = this.model.data.tasks;

                this.model.data.tasks = response.data;


                // arr.forEach(function callback(currentValue, index, array) {
                //     //your iterator
                // }[, thisArg]);

                this.model.data.tasks.forEach(updatedTask => {
                    currentTasks.forEach(async currentTask => {
                        if(updatedTask.id == currentTask.id){
                            if(updatedTask.status.id != currentTask.status.id && updatedTask.status.key == 'completed'){
                                console.log(updatedTask.status.id, currentTask.status.id);
                                // console.log(13, this.model.data.files);

                                let response = await this.request('GET', this.dataGetUrl)
                                    .then(response => {
                                        this.model.data.files = response.data;
                                    });
                            }
                        }
                    });
                });

                console.log(12, this.model.data.tasks);
                if (this.model.data.tasks.length) {
                    setTimeout(() => {
                        this.checkStatus()
                    }, 1000);
                }
            });
        }
    },
    async mounted() {
        this.checkStatus();
    }
}
</script>
