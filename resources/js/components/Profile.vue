<template>
    <div>
        <h2 class="text-left">Profile</h2>
        <div class="row">
            <div class="col-md-6">
                
                <div class="alert alert-danger" v-if="Object.keys(errors).length">
                    <ul>
                        <li v-for="error in errors">{{ error[0] }}</li>
                    </ul>
                </div>

                <form @submit.prevent="editProfile">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="profile.name">
                    </div><br>
                    <div class="form-group">
                        <label>Medium Integration Token</label>
                        <input type="text" class="form-control" v-model="profile.token">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                profile: {},
                errors: {}
            }
        },
        created() {
            var that = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/profile`)
                    .then(response => {
                        if (response.data.token == null) response.data.token = '';
                        else response.data.token = response.data.token.token;
                        this.profile = response.data;
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
