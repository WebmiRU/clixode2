import {reactive} from 'vue'

export default {
    data() {
        return {
            loading: true,
            model: {data: {}},
            dataCreate: false,
            dataGetUrl: null,
            dataPutUrl: null,
            dataPostUrl: null,
            dataDeleteUrl: null,
            dataPostBackUrl: null, //URL для перехода после успешного POST'а
            dataUploadImageUrl: '/api/image',
            dataUploadFileUrl: '/api/file',
            dataUploadFileByLinkUrl: '/api/file/link',
            dataUploadImageProgress: [],
        }
    },
    methods: {
        getCookie: function (name) {
            let results = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');

            if (results) {
                return (unescape(results[2]));
            }

            return null;
        },
        request: async function (type, url, model = null) {
            let apiToken = sessionStorage.getItem('api_token');

            const init = {
                method: type, // *GET, POST, PUT, DELETE, etc.
                // mode: 'cors', // no-cors, cors, *same-origin
                // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                // credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': this.getCookie('XSRF-TOKEN'),
                },
                // redirect: 'follow', // manual, *follow, error
                // referrer: 'no-referrer', // no-referrer, *client
                // body: JSON.stringify(model),
            }

            if(model) {
                init.body = JSON.stringify(model);
            }

            return await fetch(url, init).then(response => {
                return response.json();
            });
        },
        submit: async function () {
            if (this.dataCreate) {

                let response = await this.post(this.dataPostUrl, this.model.data);
                let dataPostBackUrl = this.dataUrl.replace(/^\/api/, '') + '/' + response.data.id

                this.$router.push(dataPostBackUrl);
            } else {
                let response = await this.put(this.dataPutUrl, this.model.data);
                Object.assign(this.model.data, response.data);
            }
        },
        uploadImage(image, imagesObject) {
            let xhr = new XMLHttpRequest();
            let formData = new FormData();
            let upload = reactive({progress: 0});

            if (!imagesObject) {
                imagesObject = this.model.data.images;
            }

            imagesObject.push(upload);

            // this.uploadImageProgress.push(upload);

            xhr.open('POST', this.dataUploadImageUrl, true);

            xhr.upload.addEventListener('progress', (e) => {
                upload.progress = (e.loaded / e.total * 100).toFixed(2) || 100;
            });

            xhr.addEventListener('readystatechange', (e) => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200 || xhr.status === 201) {
                        //Картинка успешно загружена
                        let response = JSON.parse(xhr.responseText).data;
                        // let idx = imagesObject.findIndex(v => v === upload);

                        // console.log(idx, imagesObject[idx], imagesObject);

                        response.isNew = true;
                        Object.assign(upload, response)
                    } else if (xhr.status === 422) {
                        //Ошибка при загрузке картинок
                        let response = JSON.parse(xhr.responseText);
                        alert(response.message);
                    } else {
                        alert('FATAL ERROR!!');
                    }
                }
            });

            formData.append('image', image);
            xhr.send(formData);
        },
        upload(file, type, listObject, data) {
            let apiToken = sessionStorage.getItem('api_token');
            let xhr = new XMLHttpRequest();
            let formData = new FormData();
            let upload = reactive({progress: 0});

            if (type == 'file' && !listObject) {
                listObject = this.model.data.files;
            } else if (type == 'image' && !listObject) {
                listObject = this.model.data.images;
            }

            listObject.push(upload);

            for (let key in data) {
                formData.append(key, data[key]);
            }

            xhr.open('POST', this.dataUploadFileUrl, true);
            xhr.setRequestHeader('Authorization', `Bearer ${apiToken}`);
            xhr.setRequestHeader('X-XSRF-TOKEN', this.getCookie('XSRF-TOKEN'));

            xhr.upload.addEventListener('progress', (e) => {
                upload.progress = (e.loaded / e.total * 100).toFixed(2) || 100;
            });

            xhr.addEventListener('readystatechange', (e) => {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200 || xhr.status == 201) {
                        //Картинка успешно загружена
                        let response = JSON.parse(xhr.responseText).data;

                        response.isNew = true;
                        Object.assign(upload, response);
                    } else if (xhr.status == 422) {
                        //Ошибка при загрузке
                        let response = JSON.parse(xhr.responseText);
                        alert(response.message);
                    } else {
                        alert('FATAL ERROR!!');
                    }
                }
            });

            formData.append('file', file);
            xhr.send(formData);
        },

        async uploadByLink(data){
            //запрос POST
            let response = await this.request('POST', this.dataUploadFileByLinkUrl, data);

            console.log(1);
            //запрос статуса
        },

        hookUploadImage(image) {
        },
        dataHookGetCompleted() {
        },
        dataHookPostCompleted() {
        },
        dataHookPutCompleted() {
        },
        dataHookDeleteCompleted() {
        },
    },
    async mounted() {
        //Data URL's
        if (this.dataUrl) {
            this.dataGetUrl = this.dataUrl + '/' + this.$route.params.id;
            this.dataPutUrl = this.dataUrl + '/' + this.$route.params.id;
            this.dataDeleteUrl = this.dataUrl;
            this.dataPostUrl = this.dataUrl;
        }

        if (this.dataCreate) {
            this.loading = 0;
        } else {
            if (this.dataGetUrl) {
                let response = await this.request('GET', this.dataGetUrl);

                console.log(11, this.dataGetUrl)


                this.model.data = response.data;
                this.loading = false;
                this.dataPutUrl = this.dataGetUrl;
            }
        }
    },
}
