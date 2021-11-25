<template>
<div class="container">
    <div class="row">
        <div class="col s12">
           <h4>New Post</h4>
           <div class="divider"></div>
        </div>
    </div>

    <form @submit.prevent="savePost">
        <div class="section">

            <div class="row">
                <div class="input-field col s12">
                    <input id="title" type="text" v-model="post.title">
                    <label for="title">Post Title</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <textarea id="content" name="content" class="materialize-textarea" v-model="post.content">{{ post.content }}</textarea>
                    <label for="content" class="active">Content</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="tags" type="text" v-model="post.tags" placeholder="Comma separated (Tag A,Tag B)">
                    <label for="tags">Tags</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="canonicalUrl" type="text" v-model="post.canonicalUrl">
                    <label for="canonicalUrl">Canonical Url</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="section">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="col s6">
                    <div class="section">
                        <button type="submit" class="btn submit waves-effect waves-light">Save Post</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</template>
<script>

    export default {
        data() {
            return {
                post: {},
            }
        },
        methods: {
            savePost() {
                var that = this;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`/api/posts/save`, this.post)
                        .then(response => {
                            if (response.data.success) {
                                this.$toast.success(response.data.message);
                                this.$router.push({name: 'posts'});
                            } else {
                                if (typeof response.data.errors === 'object' && !Array.isArray(response.data.errors) && response.data.errors !== null) {
                                    Object.values(response.data.errors).forEach(val => {
                                      that.$toast.error(val);
                                    });
                                } else {
                                    that.$toast.error('Error occured');
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
