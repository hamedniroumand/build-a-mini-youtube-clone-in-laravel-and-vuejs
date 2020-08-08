<template>
    <div>
        <div class="media my-3">
            <avatar
                :username="comment.user.name"
                class="mr-2"
                :size="30"
            ></avatar>
            <div class="media-body">
                <h6 class="m-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
            </div>
            <button @click.prevent="addingReply = !addingReply" class="btn btn-sm mx-1" :class="[addingReply ? 'btn-danger': 'btn-default']">
                {{ addingReply ? "Cancel" : "Add Reply" }}
            </button>
            <votes :default_votes="comment.votes" :entity_id="comment.id" :entity_owner="comment.user.id"></votes>
        </div>

        <div v-if="addingReply" class="form-row my-4 justify-content-center">
            <input v-model="body" type="text" class="w-50 form-control" />
            <div class="input-group-prepend">
                <button @click.prevent="AddReply" class="btn btn-sm btn-primary">
                    <small>Add Reply</small>
                </button>
            </div>
        </div>

        <replies ref="replies" :comment="comment"></replies>
    </div>
</template>

<script>
    import Avatar from "vue-avatar";

    export default {
        name: "Comment",
        components: {
            Avatar
        },
        props: ['comment', 'video'],
        data() {
            return {
                addingReply: false,
                body: ""
            }
        },
        methods: {
            AddReply() {
                if(this.body.trim() === "") return;
                axios.post(`/comments/${this.video.id}`, {
                    body: this.body,
                    video_id: this.video.id,
                    comment_id: this.comment.id
                }).then(({ data }) => {
                    this.body = ""
                    this.addingReply = false
                    this.$refs.replies.addReply(data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
