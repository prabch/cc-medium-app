<template>
<div class="container">
    <div class="row">
        <div class="col s12">
           <h4>Profile</h4>
           <div class="divider"></div>
        </div>
    </div>

    <div class="row" v-if="Object.keys(errors).length">
        <div class="col s12">
            <div v-for="error in errors">{{ error[0] }}</div>
        </div>
    </div>

    <form @submit.prevent="editProfile">
        <div class="section">

            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="name" type="text" placeholder="Your Name" v-model="profile.name">
                    <label for="name" class="active">Your Name</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="token" type="text" placeholder="Integration Token" v-model="profile.token">
                    <label for="token" class="active">Medium Integration Token</label>
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
                        <button type="submit" class="btn submit waves-effect waves-light">Save Changes</button>
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
