<template>
<div class="container">
    <div class="row">
        <div class="col s12">
           <h4>Medium Connect</h4>
           <div class="divider"></div>
        </div>
    </div>

    <form @submit.prevent="editMedium">
        <div class="section">

            <div class="row">
                <div class="input-field col s12 m6" v-if="medium.medium_user_id">
                    <i class="material-icons prefix green-text">electrical_services</i>
                    <input type="text" value="Connected" readonly style="border-bottom:none;">
                </div>
                <div class="input-field col s12 m6" v-else>
                    <i class="material-icons prefix gray-text">electrical_services</i>
                    <input type="text" value="Not Connected" readonly style="border-bottom:none;">
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="username" type="text" placeholder="Connected User" v-model="medium.username" disabled>
                    <label for="username" class="active">Connected User</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="token" type="text" placeholder="Integration Token" v-model="medium.token">
                    <label for="token" class="active">Integration Token</label>
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
                medium: {}
            }
        },
        created() {
            var that = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/medium`)
                    .then(response => {
                        if (response.data) this.medium = response.data;
                    })
                    .catch(function (error) {
                        that.$toast.error('Error loading details');
                    });
            })
        },
        methods: {
            editMedium() {
                var that = this;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`/api/medium/update`, this.medium)
                        .then(response => {
                            if (response.data.success) {
                                this.$toast.success(response.data.message);
                                this.medium = response.data.data;
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
