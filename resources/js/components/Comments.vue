<template>
    <div class="card mt-5 p-5">
        <div class="form-row my-4 justify-content-center">
            <input v-model="newComment" type="text" class="w-75 form-control" />
            <div class="input-group-prepend">
                <button @click.prevent="addComment" class="btn btn-sm btn-primary">
                    <small>Add Comment</small>
                </button>
            </div>
        </div>

        <comment v-for="comment in comments.data" :key="comment.id" :video="video" :comment="comment"></comment>

        <div class="text-center">
            <button
                v-if="comments.next_page_url"
                @click.prevent="fetchComments"
                class="btn btn-success"
            >
                Load More
            </button>
            <span v-else>No more comments to show :)</span>
        </div>
    </div>
</template>

<script>

export default {
    props: ["video"],

    data: () => ({
        comments: {
            data: []
        },
        newComment: ""
    }),

    mounted() {
        this.fetchComments();
    },

    methods: {
        fetchComments() {
            const url = this.comments.next_page_url
                ? this.comments.next_page_url
                : `/videos/${this.video.id}/comments`;
            axios.get(url).then(({ data }) => {
                let test = [...this.comments.data, ...data.data];
                this.comments = {
                    ...data,
                    data: test
                };
                console.log(this.comments);
            });
        },

        addComment() {
            if(this.newComment.trim() === "") return

            axios.post(`/comments/${this.video.id}`, {
                body: this.newComment
            }).then(({ data }) => {
                this.newComment = ""
                this.comments = {
                    ...this.comments,
                    data: [
                        data,
                        ...this.comments.data,
                    ]
                }
            })
        }
    }
};
</script>

<style scoped></style>
