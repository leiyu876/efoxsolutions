<style type="text/css">

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update Post</div>
                    <div class="card-body">
                        <form action="#" id="cpa-form">
                          <div class="form-group">
                            <label for="email">Title:</label>
                            <input name="title" v-model="post.title" class="form-control" id="email">
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.title ? this.errors.title[0] : '' }}
                            </small>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Featured image</label>
                            <input name="image" type="file" v-on:change="onImageChange" class="form-control-file" id="exampleFormControlFile1">
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.image ? this.errors.image[0] : '' }}
                            </small>
                          </div>
                          <div class="form-group">
                            <label for="pwd">Content</label>
                            <textarea class="form-control" id="content" v-model="post.content" name="content" rows="3"></textarea>
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.content ? this.errors.content[0] : '' }}
                            </small>
                          </div>
                          <button @click="update()" class="btn btn-success">Update</button>
                          <a href="/home"class="btn btn-primary" >Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
        },
        mounted() {
            $("#cpa-form").submit(function(e){
                return false;
            });
        },
        data : function() {
            return {
                image : null,
                errors : [],
            }
        },
        props : [
            'post'
        ],
        computed : {
        },
        methods : {
            update(){
                let formdata = new FormData();
                formdata.append("title", this.post.title);
                formdata.append("content", this.post.content);
                if(this.image) {
                    formdata.append("image", this.image);
                }
                formdata.append('_method', 'PATCH')
                axios({
                    method: 'post',
                    url: '/api/posts/' + this.post.id,
                    data: formdata,
                })
                .then((res) => {
                    window.location.href = '/home';
                })
                .catch(err => { 
                    console.log(err);
                    if(err.response.status) {
                        this.errors = err.response.data.errors;
                    }
                });
            },
            onImageChange(e){
                console.log(e.target.files[0]);
                this.image = e.target.files[0];
            },
        }
    }
</script>
