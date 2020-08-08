<template>
    <div class="col-md-8">
        <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
            <input ref="videos" @change="upload" multiple type="file" id="videos" name="videos" hidden>
            <svg id="addVideo" onclick="document.getElementById('videos').click()" xmlns="http://www.w3.org/2000/svg" fill="#f61c0d" width="70" height="70" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
            <p class="text-center">Upload Videos</p>
        </div>
        <div class="card p-3" v-else>
            <div class="my-4" v-for="video in videos">
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                         :style="{width: `${video.percentage || progress[video.name]}%`}">
                        {{ video.percentage ? video.percentage === 100 ? 'Video Processing Completed.' : 'Processing' : 'uploading' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center load-thumbnail">
                            Loading Thumbnail
                        </div>
                        <img v-else :src="video.thumbnail" class="w-100" alt="">
                    </div>
                    <div class="col-md-4">
                        <a v-if="video.percentage && video.percentage === 100" :href="`/videos/${video.id}`" target="_blank" >
                            {{ video.title }}
                        </a>
                        <div v-else class="text-center">
                            {{ video.title || video.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "Channel-uploads",

        props: {
            channel: {
                type: Object,
                required: true,
                default: () => ({})
            }
        },

        data(){
            return {
                selected: false,
                videos: [],
                progress: {},
                uploads: [],
                intervals: {},
            }
        },

        methods : {
            upload() {
                this.selected = true
                this.videos = Array.from(this.$refs.videos.files);

                const uploaders = this.videos.map(video => {
                    const form = new FormData();
                    form.append('video', video)
                    form.append('title', video.name)

                    this.progress[video.name] = 0;

                    return axios.post(`/channels/${this.channel.id}/video`, form, {
                        onUploadProgress: (event) => {
                            this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)
                            this.$forceUpdate()
                        }
                    }).then(({ data }) => {
                        this.uploads = [
                            ...this.uploads,
                            data
                        ]
                    })
                })

                axios.all(uploaders)
                .then(() => {
                    this.videos = [];
                    this.videos = this.uploads;

                    this.videos.forEach(video => {
                        this.intervals[video.id] = setInterval(() => {

                            axios.get(`/videos/${video.id}`).then(( {data} ) => {
F
                                if(data.percentage === 100) clearInterval(this.intervals[video.id])

                                this.videos = this.videos.map(v => {
                                    if(v.id === data.id) {
                                        return data
                                    }
                                    return v
                                });


                            })
                        }, 3000)
                    })
                })
            },
        },

    }
</script>



<style scoped>

</style>
