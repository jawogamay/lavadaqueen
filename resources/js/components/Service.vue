<template>
    <div class="container-fluid">
        <div class="row pt-5" v-if="$gate.laundry()">
             <div class="col-md-12">
                <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Service Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-warning" @click="newModal">Add Service <v-icon color="#fff">add_box</v-icon></button>
                         </div>
                     </div>
                </div>
             </div>
         </div>
     <v-card>
    <v-card-title>
      Services Data
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
      :items="services"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.servicetype }}</td>
        <td class="text-xs-left">Php {{ props.item.price}}</td>
        <td class="text-xs-left">{{ props.item.created_at  }}</td>

        <td class="text-xs-left">
      
                        <a href="#" class="btn btn-danger" @click="deleteService(props.item.id)">
                            <i class="fa fa-trash" style="color:#ffffff;"></i>

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
                              <h5 class="modal-title" id="addNewLabel">Add Service</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>   
                          </div>
                         <form @submit.prevent="createServices()">
                          <div class="modal-body">
                            <input type="text" name="servicetype" v-model="form.servicetype" class="form-control" placeholder="Enter Service"><br><br>
                            <input type="number" name="price" v-model="form.price" class="form-control" placeholder="Enter price" style="width:100%;">
                          </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Add</button>
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
                services:[],
                search:'',
                uploadReady:true,
                getimage:false,
                 headers:
                 [
                 {
                text: 'Service Type',
                align: 'left',
                sortable: true,
                value: 'serivcetype'
                 },
                 {text:'Price', value:'price'},
                 { text: 'Created At', value: 'created' },
                 {text:'Modify' , value:'modify'}
                 ],
                editmode: false,
                form: new Form({
                    id: '',
                    servicetype:'',
                    price:'',
                    
                })
            }
        },
        mounted(){
            if(this.$gate.laundry()){
                this.getServices();
                this.createdServices();
               /* window.Echo.channel('posts').listen('PostCreated',({post}) => {
                     this.posts.push(post)
                     console.log(posts)
                });*/
            }   
        },
        methods:{
             newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createServices(){
                this.form.post('api/services').then((response) => {
                    this.$Progress.start();
                     Fire.$emit('createdServices');
                     $('#addNew').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'Post added into account successfully'
                        })
                     this.$Progress.finish();

                })
            },
            deleteService(id){
                 swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/services/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('createdServices');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            },
            clear(){
              this.uploadReady = false
              this.$nextTick(() => {
              this.uploadReady = true
              })
            },
            getServices(){
                axios.get('api/services').then(({data}) => this.services = data);
            },
            createdServices(){
                this.getServices();
                Fire.$on('createdServices',()=>{
                    this.getServices();
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