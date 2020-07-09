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
                            <input name="name" v-model="user.name" class="form-control" id="email">
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.name ? this.errors.name[0] : '' }}
                            </small>
                          </div>
                          <div class="form-group">
                            <label for="pwd">Email</label>
                            <textarea class="form-control" id="email" type="email" v-model="user.email" name="email" rows="3"></textarea>
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.email ? this.errors.email[0] : '' }}
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
                errors : [],
            }
        },
        props : [
            'user'
        ],
        computed : {
        },
        methods : {
            update(){

                let formdata = new FormData();

                formdata.append("name", this.user.name);
                formdata.append("email", this.user.email);
                formdata.append('_method', 'PATCH')
                axios({
                    method: 'post',
                    url: '/api/users/update',
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
        }
    }
</script>
