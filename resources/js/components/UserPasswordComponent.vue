<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update Post</div>
                    <div class="card-body">
                        <form action="#" id="cpa-form">
                          <div class="form-group">
                            <label for="email">Password</label>
                            <input name="password" v-model="password" class="form-control" id="email" type="password">
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.password ? this.errors.password[0] : '' }}
                            </small>
                          </div>
                          <div class="form-group">
                            <label for="pwd">Confirm Password</label>
                            <input class="form-control" id="password_confirmation" v-model="password_confirmation" name="password_confirmation"  type="password">
                            <small class="text-danger cbrp-form-error-link">
                                {{ !!this.errors.confirm ? this.errors.confirm[0] : '' }}
                            </small>
                          </div>
                          <button @click="update()" class="btn btn-success">Update Password</button>
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
                password : '',
                password_confirmation : '',
                errors : [],
            }
        },
        props : [
        ],
        computed : {
        },
        methods : {
            update(){

                let formdata = new FormData();

                formdata.append("password", this.password);
                formdata.append("password_confirmation", this.password_confirmation);
                formdata.append('_method', 'PATCH')
                axios({
                    method: 'post',
                    url: '/api/users/password',
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
