<template>
  <div class="card-body">
    <br><br><br>
    <h1 style="text-align:center"> Update User </h1> <br><br><br>
                                        <form class="form-horizontal form-material" @submit.prevent="updateUser()">
                                            <div class="form-group">
                                                <label class="col-md-12">Full Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" :value="users.name" class="form-control form-control-line" name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" :value="users.email" class="form-control form-control-line" name="email" id="email"> 
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-12">Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" :value="users.password" class="form-control form-control-line" id="password" name="password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Confirm Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" :value="users.password" class="form-control form-control-line" id="password-confirm" name="password_confirmation">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-success">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
</template>

<script type="text/javascript">
    export default{
        data(){
            return{
                users:[],
                
            }
        },
        mounted(){
            this.getUser()
        },
        methods:{
            getUser(){
                axios.get('api/updateUser').then(({data})=> this.users=user)
            },
            updateUser(){
                 this.$Progress.start();
                // console.log('Editing data');
                axios.put('api/customers/'+this.users.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                     swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            }
        }
    }
</script>