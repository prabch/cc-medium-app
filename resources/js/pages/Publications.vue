<template>
<div class="container">
    <div class="row">
        <div class="col s12">
           <h4>Publications</h4>
           <div class="divider"></div>
        </div>
    </div>

    <div class="row" v-if="Object.keys(publications).length">
        <div class="col s12 m6 l4 xl3" v-for="{ imageUrl, id, name, description, url } in publications" :key="{id}">
          <div class="card hoverable">
            <div class="card-image waves-effect waves-block waves-light">
              <img class="activator" v-bind:src="imageUrl" style="height:300px;">
            </div>
            <div class="card-content">
              <span class="card-title activator grey-text text-darken-4">{{ name }}<i class="material-icons right">more_vert</i></span>
              <p><a v-bind:href="url" target="_blank">Read more</a></p>
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p>{{ description }}</p>
            </div>
          </div>
        </div>
    </div>

    <div class="row" v-else>
        <div class="col s12">
          <p><i class="material-icons left">info</i>No publications found !</p>
        </div>
    </div>

</div>
</template>

<script>
    export default {
        data() {
            return {
                publications: {}
            }
        },
        created() {
            var that = this;
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/publications`)
                    .then(response => {
                        if (response.data.success) {
                            this.publications = response.data.data;
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
        },
        methods: {

        },
        beforeRouteEnter(to, from, next) {
            if (!window.General.LoggedIn) return next('signin');
            next();
        }
    }
</script>
