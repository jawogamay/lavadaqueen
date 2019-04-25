<template>
    <div class="container-fluid">
     <div class="row mt-5">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <!-- Column -->
                        <div class="card">
                            <img class="card-img-top" src="/assets/images/lavada.jpg" alt="Card image cap">
                            <div class="card-body little-profile text-center">
                                <div class="pro-img"><img src="/assets/images/lavada.jpg" alt="user" /></div>
                                <h3 class="m-b-0">Lavada Queen</h3>
                                <p>Laundry Shop</p>
                            
                                <div class="row text-center m-t-20">
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">{{posts}}</h3><small>Post</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">{{customers}}</h3><small>Customers</small>
                                    </div>
                                  

                                </div>
                                <br> 
                                  <p> Rate </p>
                                  <h1> {{rates}} </h1>
                                  <form @submit.prevent = "setRating()" v-show="added ===false">
                                     <div class="star-rating">
                                    <star-rating v-model="form.rating" :increment="0.5" text-class="custom-text" :size="10" name="rating"></star-rating>
                                    <br>
                                 <button type="submit" class="btn btn-primary">Publish</button>
                                 </div>
                                 </form>

                            </div>
                        </div>
                        <!-- Column -->

                    </div>
                    <div class="col-lg-8 col-xlg-9 col-md-7">

                        <div class="card">
                               
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a>
                                </li>
                                
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                             
                                <!--second tab-->
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Laundry Shop</strong>
                                                <br>
                                                <p class="text-muted">Lavada Queen</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">(123) 456 7890</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted">lavada@gmail.com</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Location</strong>
                                                <br>
                                                <p class="text-muted">Cebu City</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h2 style="text-align:center;"> MISSION STATEMENT </h2>
                                        <br>
                                        <h4> DEFINING THE COMPANY'S MISSION: </h4>
                                        <p class="m-t-30">Lavada Queen Inc. mission statement is the constant by which we will gauge the initiative
                                        we take and the standard by which we will measure our achievement on behalf of our customers we serve.</p>
                                        <br>
                                        <h5> LAVADA QUEEN'S MISSION: </h5>
                                        <p>The company's primary objective is to take care of our customers, have the best work environment for our staff, and enhance people's life with modern service and use of least toxic cleaning formulas available for a better environment to live. We earn our customer's trust by serving them in a reliable timely and helpful manner, by providing high quality service at a reasonable competitive price, and by actively taking initiative to meet their needs. We are in the laundry business not only to meet our customer's expectations, but to exceed them. </p>
                                        
                                        <h2 class="font-medium m-t-30">Why Us???</h2>
                                        <hr>
                                            <ul>
                                                <li> <h6> Long history - since 1997 </h6></li>
                                                <li> <h6> Professional in laundry service </h6></li>
                                                <li> <h6> Quality is our mantra </h6></li>
                                                <li> <h6> Excellent reference on servicing group </h6></li>
                                                <li> <h6> Adequate Capacity </h6></li>
                                                <li> <h6> International Fabric Care Institute membership </h6></li>
                                                <li> <h6> Timely Service </h6></li>
                                                <li> <h6> Realistic Contingency Plan </h6></li>
                                                <li> <h6> One Stop Customer Service With </h6></li>
                                                <li> <h6> Tailoring Specialist On-Site. Complimentary Minor Repairs. </h6></li>
                                                <li> <h6> Competitive Price</h6></li>
                                                <li> <h6> Cost saving means additional profit to the group</h6></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
    </div>
</div>
</template>

<script>
  
    export default{
         data(){
            return{
                added: false,
                customers:[],
                posts:[],
                rates:0,
                form:new Form({
                    rating: 0,
                   
                })
            }
         },
         created(){
            this.getRating();
            this.createdRating();
            this.countCustomer();
             this.countPost();
         },
         methods:{
            countPost(){
        axios.get('api/countPost').then(({data}) => {
            this.posts = data;
        })
         },
         countCustomer(){
        axios.get('api/countCustomer').then(({data}) => {
            this.customers = data;
        })
         },
         setRating(){

            this.form.post('api/rating').then((response) => {
                this.$Progress.start();
            
            Fire.$emit('createdRating');
              toast.fire({
                            type: 'success',
                            title: 'Post added into account successfully'
                        })
                     this.$Progress.finish();
            })
            this.added = true;
         },
         getRating(){
             axios.get('api/getrate').then(({data}) => this.rates = data);
         },
         createdRating(){
            this.getRating();
            Fire.$on('createdRating',()=>{
                this.getRating();
            })
         }
        }
    };
</script>

<style type="text/css" scoped>
    
</style>