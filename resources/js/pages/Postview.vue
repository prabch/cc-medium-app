<template>
<div class="container">
    <div class="row">
        <div class="col s12">
           <h4>{{  post.title }}
                <button v-if="!post.medium_id" class="btn submit waves-effect waves-light red right" @click="submitMedium"><i class="material-icons left">chevron_right</i>Submit to Medium</button>
                <button v-else class="btn submit waves-effect waves-light right" disabled>Submitted to Medium</button>
           </h4>
           <p>Posted on {{  post.created_at }}</p>
           <div class="divider"></div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
          <p>{{  post.content }}</p>
        </div>
    </div>

    <div class="row" v-if="post.tags">
        <div class="col s12">
           <h6>Tags</h6>
           <div class="divider"></div>
           <br>
           <span class="new badge blue" data-badge-caption="" v-for="track in post.jtags">{{ track }}</span>
        </div>
    </div>

</div>
</template>

<script>
    export default {
        data() {
            return {
                post: {},
            }
        },
        created() {
            var that = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/posts/read/${this.$route.params.id}`)
                    .then(response => {
                        this.post = response.data;
                        if (response.data.tags) this.post.jtags = JSON.parse(response.data.tags);
                    })
                    .catch(function (error) {
                        that.$toast.error('Post loading error');
                    });
            })
        },
        methods: {
            submitMedium(e) {
                e.preventDefault()
                var that = this;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`api/posts/publish/${this.$route.params.id}`)
                    .then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message);
                            this.$router.push({name: 'posts'});
                        } else {
                            if (typeof response.data.errors === 'object' && !Array.isArray(response.data.errors) && response.data.errors !== null) {
                                Object.values(response.data.errors).forEach(val => {
                                  this.$toast.error(val);
                                });
                            } else {
                                this.$toast.error('Error occured');
                            }
                        }
                    })
                    .catch(function (error) {
                        if (typeof error.response.data.errors === 'object' && !Array.isArray(error.response.data.errors) && error.response.data.errors !== null) {
                            Object.values(error.response.data.errors).forEach(val => {
                              that.$toast.error(val);
                            });
                        } else {
                            that.$toast.error('Error occured');
                        }
                    });
                })
            }
        },
        beforeRouteEnter(to, from, next) {
            if (!window.General.LoggedIn) return next('signin');
            next();
        }
    }
</script>