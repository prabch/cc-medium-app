<template>
    <div class="container">
        <div class="row">
            <div class="col s12">
               <h4>Sign In</h4>
               <div class="divider"></div>
            </div>
        </div>

        <form>
            <input type="hidden" name="submit" value="true">
            <div class="section">

                <div class="row">
                    <div class="input-field col s12 m6 l3">
                          <input id="username" type="text" v-model="email">
                          <label for="username">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m6 l3">
                          <input id="password" type="password" class="validate" v-model="password">
                          <label for="password">Password</label>
                          <p>Don't have an account ? <router-link to="/signup">Sign Up Here</router-link></p>
                    </div>              
                </div>

                <div class="row">
                    <div class="col s12">
                       <div class="divider"></div>
                        <div class="section">
                            <button class="btn submit waves-effect waves-light" @click="handleSubmit">Sign In</button>
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
            email: '',
            password: ''
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                var that = this;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message);
                            window.General.LoggedIn = true;
                            window.location.href = "/posts";
                            //this.$router.push({name: 'posts'});
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
            } else {
                this.$toast.error('Password cannot be blank');
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.General.LoggedIn) return next('posts');
        next();
    }
}
</script>
