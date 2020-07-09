<style type="text/css">

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts Listing

                        <a href="/posts/create" class="btn btn-success pull-right" >Create</a>
                        <div class="row">
                          <div class="col-md-4">
                          
                          <input @keyup="searchKeyUp" v-model="search_string" class="form-control form-control-md" type="text" placeholder="Search Title">

                          </div>
                          <div class="col-md-4 offset-md-4">
                              <select class="form-control" id="paginate_value" @input="paginateChange()">
                                <option v-for=" paginate in paginates " >{{ paginate }}</option>
                              </select>
                          </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Published</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(post, index) in posts" :key="post.id">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <img :src="post.imagePath" style="width:63px;">
                                </td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.createdAtHumanReadable }}</td>
                                <td>{{ post.updatedAtHumanReadable  }}</td>
                                <td>
                                    <i @click="tooglePublish(post)" :class="'fa fa-' + (post.is_published ? 'check' : 'times') " aria-hidden="true"></i>
                                    <a :href="'/posts/' + post.id + '/edit'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <i @click="remove(post.id)" class="fa fa-trash" aria-hidden="true"></i>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                          <nav v-if="posts.length > 0 && last_page != 1"  aria-label="Page navigation example">
                              <ul class="pagination">
                                <li v-if="current_page != 1" @click="btn_link_click(current_page - 1)" class="page-item">
                                    <a class="page-link" href="javascript:void(0)">
                                        &laquo;
                                    </a>
                                </li>
                                <li v-for="(btn, index) in paginate_btns" :key="index"  :class="'page-item ' + (btn == current_page ? 'active' : '')">
                                    <a class="page-link" href="javascript:void(0)" @click="btn_link_click(btn)">{{ btn }}</a>
                                </li>

                                <!-- Use class name 'cbrp-pagination__nextbtn--inactive' if next button needs to be inactive -->
                                <li v-if="current_page != last_page" @click="btn_link_click(current_page + 1)" class="page-item">
                                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                                        &raquo;
                                    </a>
                                </li>
                              </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.fetchPosts()
        },
        mounted() {
        },
        data : function() {
            return {
                posts : [],
                paginates : [10, 20, 50, 100],
                paginate_value : null,

                search_string : '',
                paginate_btns : [],
                current_page : null,
                last_page : null,
                total : null,
                from : null,
                to : null,
                page : 1,
                limit : 10,
            }
        },
        props : [
        ],
        computed : {
        },
        methods : {
            fetchPosts(page) {
                axios({
                    method: 'get',
                    url: '/api/posts',
                    params: {
                        page : page,
                        limit : this.limit,
                        search_string : this.search_string
                    },
                })
                .then((res) => {
                    this.posts = res.data.data

                    this.current_page =  res.data.meta.current_page
                    this.last_page = res.data.meta.last_page
                    this.total = res.data.meta.total
                    this.from = res.data.meta.from
                    this.to = res.data.meta.to
                    this.composePagination()
                })
                .catch(error => { console.log(error) });
            },
            remove(id) {
                if (confirm("Remove post?")) {
                  axios({
                        method: 'post',
                        url: '/api/posts/' + id,
                        data: {
                            _method : 'DELETE',
                        },
                    })
                    .then((res) => {
                        this.fetchPosts()
                    })
                }
            },
            tooglePublish(post) {

                let publish_text = !post.is_published ? 'publish' : 'unpublish';

                if (confirm("Are you sure you want to "+ publish_text +"?")) {
                  axios({
                        method: 'post',
                        url: '/api/posts/' + post.id + '/toogle-publish',
                    })
                    .then((res) => {
                        location.reload()
                    })
                    .catch(error => { console.log(error) });
                }
                
            },
            composePagination : function() {
                this.paginate_btns = []
                let btn_begin = this.current_page - 3
                let btn_last  = this.current_page + 3

                for (var i = btn_begin; i <= btn_last; i++) {

                    if(i > 0 && i <= this.last_page) {

                        this.paginate_btns.push(i)
                    }
                }
            },
            btn_link_click : function(btn) {
                this.page = btn
                this.fetchPosts(btn)
            },
            searchKeyUp: _.debounce(function (e) {
                this.search_string = e.target.value;
                this.fetchPosts(1)
            }, 500),
            paginateChange() {
                this.limit = $('#paginate_value').val()
                this.fetchPosts(1)
            }
        }
    }
</script>
