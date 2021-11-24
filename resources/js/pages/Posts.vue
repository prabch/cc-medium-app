<template>
    <div>
        <h2 class="text-left">Posts</h2>
        <div class="row">
            <div class="col-md-6">
                
                <div class="alert alert-danger" v-if="Object.keys(errors).length">
                    <ul>
                        <li v-for="error in errors">{{ error[0] }}</li>
                    </ul>
                </div>

                <div v-if="Object.keys(posts).length">


                    <div v-for="{ id, name, description} in posts" :key="{id}">
                        <div class="table-row__index">
                          {{ id }}
                        </div>
                        <div class="table-row__title">
                        <p> {{ name }}</p>
                        </div>
                        <div class="table-row__info">
                            {{ description }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: {},
                errors: {}
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
                        that.errors = error.response.data.errors
                    });
            })
        },
        methods: {
            editProfile() {
                var that = this;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`/api/profile/update`, this.profile)
                        .then(response => {
                            this.$router.push({name: 'profile'});
                        })
                        .catch(function (error) {
                            that.errors = error.response.data.errors
                        });
                })
            }
        },
        beforeRouteEnter(to, from, next) {
            if (!window.general.isLoggedin) {
                window.location.href = "/";
            }
            next();
        }
    }
</script>
