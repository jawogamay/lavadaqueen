<template>
    <div class="container-fluid">
        <div class="row pt-5" v-if="$gate.laundry()">
             <div class="col-md-12">
                <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Post Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-warning" @click="newModal">Add Post <v-icon color="#fff">add_box</v-icon></button>
                         </div>
                     </div>
                </div>
             </div>
         </div>
     <v-card>
    <v-card-title>
      Customers Data
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="posts"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.title }}</td>
        <td class="text-xs-left">{{ props.item.content}}</td>
        <td class="text-xs-left">{{ props.item.created_at  }}</td>
        <td class="text-xs-left">
             <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                        /
                        <a href="#" @click="deletePost(props.item.id)">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </a>
        </td>
      </template>
      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add Post</h5>
                            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="editmode ? updateUser() :createPost()">
                        <div class="modal-body">
                           <!--  <select class="form-control" name="transaction_id" v-model="form.transaction_id">
                                <option value="">---Select Account Name---</option>
                                <option  v-for="account in accounts" :key="account.id" :value="account.id">{{account.account_name}}</option>
                            </select>
                            <br>
                            <input type="text" class="form-control" placeholder="Enter Passenger Name" name="passenger_name" v-model="form.passenger_name"><br>   -->   
                            <input type="text" name="title" placeholder="Enter title of post" :class="{'is-invalid': form.errors.has('content') }" v-model="form.title" class="form-control">
                            <has-error :form="form" field="title"></has-error>
                            <br><br>
                            <textarea class="form-control" placeholder="Whats on your mind ?" :class="{'is-invalid': form.errors.has('content') }" style="height:200px;" name="content" v-model="form.content">
                            </textarea>
                            <has-error :form="form" field="content"></has-error>
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Post</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>
    </div>
</template> 

<script>
    export default{
        data(){
            return{
                 posts:[],
                 search:'',
                 headers:
                 [
                 {
                text: 'Title',
                align: 'left',
                sortable: true,
                value: 'title'
                 },
                 {text:'Content', value:'content'},
                 { text: 'Created At', value: 'created' },
                 {text:'Modify' , value:'modify'}
                 ],
                editmode: false,
                form: new Form({
                    id: '',
                    content:'',
                    title:'',
                    image:'',
                })
            }
        },
        mounted(){
            if(this.$gate.laundry()){
                this.getPost();
                this.createdPost();
                window.Echo.channel('posts').listen('PostCreated',({post}) => {
                     this.posts.push(post)
                     console.log(posts)
                });
            }   
        },
        methods:{
             newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createPost(){
                this.form.post('api/posts').then((response) => {
                    this.$Progress.start();
                     Fire.$emit('createdPost');
                     $('#addNew').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'Post added into account successfully'
                        })
                     this.$Progress.finish();

                })
            },
            deletePost(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
            },
            getPost(){
                axios.get('api/posts').then(({data}) => this.posts = data);
            },
            createdPost(){
                this.getPost();
                Fire.$on('createdPost',()=>{
                    this.getPost();
                })
            }
        }
    };
</script>
<style type="text/css" scoped>
    
    .text-xs-left .fa {
        font-size: 20px;
    }
</style>