<template>
    <div class="container">
        <div class="row">
            <div class="col s12">
               <h4>Posts
               <router-link to="/posts/new" class="btn right"><i class="material-icons left">post_add</i>New Post</router-link>
               </h4>
               <div class="divider"></div>
            </div>
        </div>

        <div class="row" v-if="Object.keys(posts).length">
            <div class="col s12" v-for="{ id, title, excerpt, tags } in posts" :key="{id}">
              <router-link :to="{name: 'post', params: { id: id }}">
              <div class="card hoverable">
                <div class="card-content">
                  <span class="card-title">{{ title }}<span class="right">{{ id }}</span></span>
                  <p>{{ excerpt }}</p>
                </div>
              </div>
              </router-link>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col s12">
              <p><i class="material-icons left">info</i>No posts found !</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: {}
            }
        },
        created() {
            var that = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/posts`)
                    .then(response => {
                        this.posts = response.data;
                    })
                    .catch(function (error) {
                        this.posts = {};
                    });
            })
        },
        methods: {

        },
        beforeRouteEnter(to, from, next) {
            if (!window.General.LoggedIn) return next('signin');;
            next();
        }
    }
</script>
