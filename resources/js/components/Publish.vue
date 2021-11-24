<template>
    <div>
        <h4 class="text-center">Publish Story</h4>
        <div class="row">
            <div class="col-md-6">

                <form @submit.prevent="addBook">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="post.title">
                    </div><br>
                    <div class="form-group">
                        <label>Content</label>
                        <input type="text" class="form-control" v-model="post.content">
                    </div><br>
                    <div class="form-group">
                        <label>tags</label>
                        <input type="text" class="form-control" v-model="post.tags">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Publish</button>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: {}
        }
    },
    methods: {
        addBook() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/books/add', this.post)
                    .then(response => {
                        this.$router.push({name: 'books'})
                    })
                    .catch(function (error) {
                        console.error(error);
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
