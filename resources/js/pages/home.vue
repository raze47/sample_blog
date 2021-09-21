<template>
    <card :title="$t('home')">
        <div class="card-body">
            <form action="" id="user-post" method="post" @submit.prevent="postContent()">
                <div class="form-group">
                    <label for="exampleInputEmail1">Write a post!</label>
                    <textarea name="posts_text" class="form-control" v-model="posts_text" height="500px" placeholder="Post here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-md">Post</button>
            </form>

            <br />
            <br />
            <hr />
            <br />
            <br />

            <div v-for="(item,index) in post_items" v-bind:key="item.id" :loading="loading">
                <div class="posts-container">
                    <h5>{{item.user['name']}}</h5>
                    <br />
                    <h6>{{item.content}}</h6>
                    <br />
                    <br />

                    <button v-if="curr_user == item.user_id" class="btn btn-sm btn-primary" @click="initUpdatePost()">Update</button>
                    <div v-if="posts_update == true">
                        
                        <textarea v-model="list_posts_update[index]" class="form-control mb-1" rows="2" placeholder="Update post"></textarea>
                        <br />
                        <button class="btn btn-sm btn-warning" @click="updatePost(item.post_id, list_posts_update[index])">Update</button>
                        <hr />

                    </div>
                    
                    <h5>Comments: </h5>
                    <div v-for="comment_home in comments_home" v-bind:key="comment_home.id">
                       
                        <div v-if = "comment_home.post_id == item.post_id">
                             <button v-if="curr_user == comment_home.user_id" class="btn btn-sm btn-danger" @click="deleteComment(comment_home.comment_id)">X</button>
                             <b>{{comment_home.created_at}}</b>
                             <br>
                            <b>{{comment_home.user['name']}}</b>: {{comment_home.comment}}
                           
                            <br>
                            <br>
                        </div>
                    
                    </div>
                     <br />
                    <button v-if="curr_user == item.user_id" class="btn btn-danger" @click="deletePost(item.post_id)">Delete Post</button>
                    <br />
                    <br />

                    
                 
                        <textarea v-model="list_comments_text[index]" class="form-control mb-1" rows="2" placeholder="Comment here"></textarea>
                        <br />
                        <button class="btn btn-success" @click="commentStore(item.post_id, list_comments_text[index])">Submit Comment</button>
                        <hr />
                 
                  
                </div>
            </div>
        </div>
    </card>
</template>

<script>
    import axios from "axios";
    import moment from 'moment';

    export default {
        middleware: "auth",

        

        metaInfo() {
            return { title: this.$t("home") };
        },

        data() {
            return {
                posts_text: "",
                comments_text: "",
                post_items: undefined,
                comments_home: undefined,
                curr_user: undefined,
                list_comments_text: [],
                list_posts_update: [],
                posts_update: false,
                page: 1,
                loading: true,
            };
        },

        mounted() {
            this.init();
        },

        methods: {
            async init(){
                try{
                    posts_update: false;
                    this.initPosts();
                    this.initComments();
                }
                catch(error){
                    console.log(error);
                }
            },

            async initPosts(){
                try {
                    axios
                        .get("/api/post_content/show")
                        .then((resp) => {
                            var x = resp.data
                            this.post_items = x.data.data;
                            this.curr_user = x.auth_user;
                            console.log(resp);
                            console.log("Auth user: ");
                            console.log(this.curr_user);
                            console.log(this.post_items);
                        })
                        .catch((error) => {
                      
                            console.log(error);
                        });
            
                } catch (error) {
                    console.log(error);
                }

            },

            async initComments(){
                try {
                    axios
                        .get("/api/post_comment/show")
                        .then((resp) => {
                            this.comments_home = resp.data.data.data;
                            console.log(this.comments_home);
                        })
                        .catch((error) => {
                      
                            console.log(error);
                        });
            
                } catch (error) {
                    console.log(error);
                }

            },

            async postContent() {
                await axios.post("/api/post_content/store", { posts_text: this.posts_text });
                this.initPosts();
            },

            async deletePost(post_id_del) {
           
                await axios.post("/api/post_content/destroy", { post_id: post_id_del });
                this.initPosts();
            },

            async deleteComment(comment_id_del){
                await axios.post("/api/post_comment/destroy", { comment_id: comment_id_del });
                this.initComments();
            },
   


            async commentStore(post_id_comment, comments_text) {
                await axios.post("/api/post_comment/store", {post_id: post_id_comment, comment: comments_text });
                this.initComments();
            },

            async initUpdatePost(){
                this.posts_update = true;
            },

            async updatePost(post_id_update, post_update){
                await axios.post("/api/post_content/update", {post_id: post_id_update, posts_text: post_update });
                this.initPosts();
            }

            
        },
    };
</script>
