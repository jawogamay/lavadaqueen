<template>
    <div class="container" v-if="$gate.customer()">
      <div class="card-body mt-5" v-for="post in posts">
        <div class="blog-image">
            
            <img :src="post.image" alt="img" class="img-responsive"/>
        </div>
        <br>
            <h1>{{post.title}}</h1>
                <label class="label label-rounded label-success">{{post.user.name}}</label>
                <p class="m-t-20 m-b-20">
                   {{post.content}}
                </p>
                     <div class="d-flex">
                    <div class="read"><router-link to="/profile" class="link font-medium">View Profile</router-link></div>
                    <div class="ml-auto">
                         <a href="javascript:void(0)" class="link m-r-10 " data-toggle="tooltip" title="Like"><i class="mdi mdi-heart-outline"></i></a>
                </div>
             </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                posts: []
            }
        },
        created(){
            if(this.$gate.customer()){
                this.viewPost();

            }
        },
        methods:{
            viewPost(){
                axios.get('api/viewpost').then(({data}) => this.posts = data)
            },
          
        }
    };
</script>