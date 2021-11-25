<template>
  <header>
    <nav class="top-nav blue">
      <div class="container">
          <div class="nav-wrapper">
            
              <ul class="right hide-on-med-and-down" v-if="LoggedIn">
                <li><router-link to="/medium"><i class="material-icons left">electrical_services</i>Medium Connect</router-link></li>
                <li><a @click="logout"><i class="material-icons left">power_settings_new</i>Sign Out</a></li>
              </ul>
            
              <a href="/" class="brand-logo center baseurl">Medium App</a>

            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <ul id="nav-mobile" class="left hide-on-med-and-down" v-if="LoggedIn">
                <li><router-link to="/publications"><i class="material-icons left">feed</i>Publications</router-link></li>
                <li><router-link to="/posts"><i class="material-icons left">article</i>Posts</router-link></li>
            </ul>

            <ul id="nav-mobile" class="left hide-on-med-and-down" v-else>
                <li><router-link to="/"><i class="material-icons left">grid_view</i>Home</router-link></li>
                <li><router-link to="/signin"><i class="material-icons left">person</i>Sign In</router-link></li>
                <li><router-link to="/signup"><i class="material-icons left">person_add</i>Sign Up</router-link></li>
            </ul>

          </div>
      </div>
    </nav>

    <ul class="sidenav" id="mobile-demo" v-if="LoggedIn">
        <li><router-link to="/publications"><i class="material-icons left">feed</i>Publications</router-link></li>
        <li><router-link to="/posts"><i class="material-icons left">article</i>Posts</router-link></li>
        <div class="divider"></div>
        <li><router-link to="/medium"><i class="material-icons left">electrical_services</i>Medium Connect</router-link></li>
        <li><a @click="logout"><i class="material-icons left">power_settings_new</i>Sign Out</a></li>
    </ul>

    <ul class="sidenav" id="mobile-demo" v-else>
        <li><router-link to="/"><i class="material-icons left">grid_view</i>Home</router-link></li>
        <li><router-link to="/signin"><i class="material-icons left">person</i>Sign In</router-link></li>
        <li><router-link to="/signup"><i class="material-icons left">person_add</i>Sign Up</router-link></li>
    </ul>

  </header>

  <main>
    <router-view/>
  </main>
</template>

<script>
    import M from 'materialize-css';

    export default {
        name: "App",
        mounted () {
            M.AutoInit();
        },
        data() {
            return {
                LoggedIn: false,
            }
        },
        created() {
            if (window.General.LoggedIn) this.LoggedIn = true;
        },
        methods: {
            logout(e) {
                e.preventDefault();
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/logout')
                        .then(response => {
                            if (response.data.success) {
                                this.$toast.success('Logging you out...');
                                this.LoggedIn = window.General.LoggedIn = false;
                                this.$router.push({name: 'signin'});
                            } else {
                                this.$toast.error('Please try again');
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        },
    }
</script>