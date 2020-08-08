require("./bootstrap");

window.Vue = require("vue");

Vue.component(
    "subscribe-btn",
    require("./components/Subscribe-btn.vue").default
);
Vue.component(
    "channel-uploads",
    require("./components/Channel-uploads.vue").default
);
Vue.component("votes", require("./components/Votes.vue").default);
Vue.component("comments", require("./components/Comments.vue").default);
Vue.component("comment", require("./components/Comment.vue").default);
Vue.component("replies", require("./components/Replies.vue").default);

Vue.config.ignoredElements = ["video-js"];
const app = new Vue({
    el: "#app"
});
