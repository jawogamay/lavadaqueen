<template>
    <div class="container-fluid">
        <div class="row pt-5" v-if="$gate.laundry()">
             <div class="col-md-12">
                <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Transaction Table</h3>
                        <div class="card-tools">
                        </div>
                     </div>
                       <v-card>
    <v-card-title>
      Transaction Data
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
      :items="transactions"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.customer.name }}</td>
        <td class="text-xs-left">{{ props.item.service}}</td>
         <td class="text-xs-left">{{ props.item.weight}}</td>
          <td class="text-xs-left"><span  class="label label-warning">{{ props.item.status.name}}</span></td>
         
           <td class="text-xs-left" >Php{{ props.item.total}}</td>
        <td class="text-xs-left">{{ props.item.created_at |myDate }}</td>
        <td class="text-xs-left">
                        <a href="#" class="btn btn-primary" @click="editModal(props.item)">
                           Transact
                        </a>
                        <a href="#" class="btn btn-warning" @click="editStatus(props.item)">
                            Status change
                        </a>
                        <a href="#" class="btn btn-danger" @click="editStatus(props.item)">
                          <i class="fa fa-trash"> </i>
                        </a>
        </td>
      </template>
      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>
                </div>
             </div>
         </div>
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         
                            <h5 class="modal-title"  id="addNewLabel">Update Transaction Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent=" updateAppointment()">
                        <div class="modal-body">
                            <input type="text" :value="form.name" class="form-control" disabled name="user"><br><br>
                            <input type="service" :value="form.service" class="form-control" disabled name="service" > 
                            <br>
                             <!-- <select name="status" class="form-control" v-model="form.status">
                                <option v-for="status in statuses" :key="status.id" :value="status.id">{{status.name}}</option>
                            </select> -->
                            <br><br>
                            <input type="number" class="form-control" v-model="form.weight" name="weight" placeholder="Enter kilogram weight" style="width:100%;">
                            <br><br>
                           <div v-if="form.service === 'Fullservice'">
                            <h3>PHP: </h3>
                                <input type="service" v-model="form.total = form.weight*23"   class="form-control" disabled name="total" >     
                          </div> 
                          <div v-if="form.service === 'Vintage'">
                            <h3>PHP: </h3>
                                <input type="service" v-model="form.total = form.weight*32"   class="form-control" disabled name="total" >     
                          </div> 
                            <div v-if="form.service === 'Finelinen'">
                            <h3>PHP: </h3>
                                <input type="service" v-model="form.total = form.weight*28"   class="form-control" disabled name="total" >     
                          </div> 
                           <div v-if="form.service === 'Garment'">
                            <h3>PHP: </h3>
                                <input type="service" v-model="form.total = form.weight*38"   class="form-control" disabled name="total" >     
                          </div> 
                             <div v-if="form.service === 'Carpet'">
                            <h3>PHP: </h3>
                                <input type="service" v-model="form.total = form.weight*45"   class="form-control" disabled name="total" >     
                          </div> 
                            </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>
             <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         
                            <h5 class="modal-title"  id="addNewLabel">Update Transaction Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="statusUpdate()">
                        <div class="modal-body">
                           <h3 style="display:inline;"> Current Status:</h3> &nbsp;<span style="display:inline; color:blue;"><b>{{ this.form.current}}</b></span>
                           <br>
                             <select name="status" class="form-control" v-model="form.status">
                                <option v-for="status in statuses" :key="status.id" :value="status.id">{{status.name}}</option>
                
                            </select>
                          
                          
                            </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>`
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
                 transactions:[],
                  search:'',
                  price:0,
                  statuses:[],
                 headers:
                 [
                 {
                text: 'Name',
                align: 'left',
                sortable:true,
                value: 'customer.name'
                 },
                 {text:'Service', value:'service'},
                 {text:'Weight' ,value:'weight'},
                 {text:'Status' ,value:'status'},
                 {text:'Total',value:'total'},
                 { text: 'Created At', value: 'created_at' },
                 {text:'Modify' , value:'modify'}
                 ],
                form: new Form({
                    id: '',
                    name:'',
                    service:'',
                    weight:'',
                    total:'',
                    status:'',
                    current:''
                   
                    
                })
            }
        },
        mounted(){
            if(this.$gate.laundry()){
                this.loadTransact();
                this.loadStatus();
                this.statusChanged();
            }
        },
        methods:{
             /*newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },*/
            statusUpdate(){
              let status = this.form.status
             this.form.put('api/statuschange/'+this.form.id)
              .then(()=>{
                this.$Progress.start();
                 $('#changeStatus').modal('hide')
                     toast.fire(
                        'Updated!',
                        'Status has been updated.',
                        'success'
                        )
                     this.$Progress,finish();
                     Fire.$emit('statusChanged')
              })
            },
            editStatus(changestatus){
              this.form.id = changestatus.id
              this.form.current = changestatus.status.name
              this.form.status = changestatus.status
                $('#changeStatus').modal('show')
            },
             editModal(transaction){
                this.form.id  = transaction.id
                this.form.user_id = transaction.user_id
                this.form.name = transaction.customer.name
                this.form.service = transaction.service
                this.form.total = transaction.total
                this.form.weight = transaction.weight
                $('#addNew').modal('show')
            },
            updateAppointment(){
              this.form.put('api/transactions/'+this.form.id)
              .then(()=>{
                  this.$Progress.start();
                  $('#addNew').modal('hide')
                     toast.fire(
                        'Updated!',
                        'Transaction has been updated.',
                        'success'
                        )
                     this.$Progress,finish();
                     Fire.$emit('statusChanged')

              }).catch((err)=>{
                console.log(err);
              })
            },
            loadTransact(){
            axios.get('api/transactions').then(({data}) => this.transactions = data)
            },
            statusChanged(){
              this.loadTransact();
              Fire.$on('statusChanged',()=>{
                this.loadTransact();
              })
            },
            loadStatus(){
                axios.get('api/getstatus').then(({data}) => this.statuses = data)
            }
        },
  
        
    };
</script>