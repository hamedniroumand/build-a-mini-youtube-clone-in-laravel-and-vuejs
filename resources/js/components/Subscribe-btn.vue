<template>
    <button @click.prevent="toggleSubscription" class="btn btn-danger">
        {{ owner ? '' : subscribed ? `Unsubscribe ` : "Subscribe " }}{{count}} {{ owner ? "Subscribed" : '' }}
    </button>
</template>

<script>
    import numeral from 'numeral';

    export default {
        name: "subscribe-btn",

        props: {
            initialSubscriptions: {
                type: Array,
                required: true,
                default: () => ([])
            },
            channel: {
                type: Object,
                required: true,
                default: () => ({})
            }
        },

        data(){
            return {
                subscriptions: this.initialSubscriptions
            }
        },

        computed: {
            subscribed() {
                if(!__auth() || this.channel.user_id === __auth().id) return false;
                return !! this.subscription;
            },

            owner() {
                if(__auth() && this.channel.user_id ===  __auth().id) return true;
                return false;
            },

            count() {
                return numeral(this.subscriptions.length).format('0a')
            },

            subscription() {
                if(! __auth()) return null;
                return this.subscriptions.find(s => s.user_id === __auth().id)
            }
        },

        methods: {
            toggleSubscription(){
                if(!__auth()) return alert("Please login to  subscribe.")
                else if(this.owner) return alert("You cannot subscribe to your channel")

                if(this.subscribed){ /* channels/{channel}/subscriptions/{subscription} */
                    axios.delete(`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
                        .then(() => {
                            this.subscriptions = this.subscriptions.filter(s => s.id !== this.subscription.id)
                        })
                }else {  /* channels/{channel}/subscriptions  */
                    axios.post(`/channels/${this.channel.id}/subscriptions`)
                    .then((res) => {
                        this.subscriptions = [
                            ...this.subscriptions,
                            res.data
                        ]
                    })
                }
            }
        },
    }
</script>

<style scoped>

</style>
