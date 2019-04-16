<template>
    <div class="container-fluid">
        <div class="row pt-5" v-if="$gate.customer()">
             <div class="col-md-12">
                <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Transaction</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Add Transaction <v-icon color="#fff">add_box</v-icon></button>
                         </div>
                     </div>
                </div>
             </div>
         </div>
           <div class="col-lg-3 col-md-6" v-for="transact in transacts" :key="transact.id" >
                        <div class="card">
                            <div class="card-body">
                                <div class="row p-t-10 p-b-10">
                                    <!-- Column -->
                                    <div class="col p-r-0">
                                        <h3 class="font-light">Php{{transact.total}}</h3>
                                        <h6 class="text-muted">{{transact.service}}</h6>
                                        <span class="label label-primary">{{transact.status.name}}</span>
                                    </div>
                                    <!-- Column -->
                                    <div class="col text-right align-self-center">
                                        <div data-label="100%" class="css-bar m-b-0 css-bar-danger css-bar-100"><i class="mdi mdi-briefcase-check"></i></div>
                                        <br><br>
                                        <button class="btn btn-danger" @click= "viewTransact(transact)">Full Details </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewLabel">Add Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                       <form @submit.prevent="createTransaction()">
                        <div class="modal-body">
                            <input type="date" name="date" v-model="form.date" class="form-control" :class="{'is-invalid': form.errors.has('date') }">
                            <has-error :form="form" field="date"></has-error>
                            <br><br>
                            <select name="service"  v-model="form.service" class="form-control" required :class="{'is-invalid': form.errors.has('service') }">
                                <option value="" disabled selected>------------ Choose service ---------------</option>
                                <option value="Fullservice">Full Service</option>
                                <option value="Finelinen">Fine Linen & Table Clothes</option>
                                <option value="Vintage">Bridal and Vintage Items</option>
                                <option value="Garment">Garment Repair & Alteration</option>
                                <option value="Carpet">Carpet & Upholster Cleaning</option>
                            </select>
                            <has-error :form="form" field="service"></has-error>
                            <br><br>
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                     </form>
                </div>
            </div>
            
            </div>
           <div class="modal fade" id="viewdetails" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewLabel">View Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>   
                        </div>
                        <div class="modal-body">
                            <div>
                                <h5 style="display:inline;"><b>Date Reservation :</b> </h5><span style="display:inline;color:blue;"> <b>{{form.date |myDate}} </b></span>
                             </div>
                             <div>
                                <h5 style="display:inline;"><b>Weight :</b> </h5><span style="display:inline;color:green;"><b> {{form.weight}}kg </b></span>
                            </div>
                             <div>
                                <h5 style="display:inline;"><b>Service :</b> </h5><span style="display:inline;color:indigo;"><b> {{form.service}}</b></span>
                            </div>
                            <br><br>
                              <div class="progress">
                                  <progressbar :now="form.percent" label type="success" striped animated></progressbar>
                               </div>
                               <br>
                               <h3 style="display:inline;"> <b>Status: </b></h3> <span style="display:inline;color:red;">{{form.status}}</span>
                               <img src="/images/tenor.gif" alt="delivery" v-if="form.percent >= 100"  style="width:100%;">
                        </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     </div>
              
                </div>
            </div>
            
            </div>
    </div>
</template> 

<script>
import { progressbar } from 'vue-strap'
    export default{
        components: {
            progressbar
        },

        props: ['status', 'initial', 'transaction_id'],
        data(){
            return{
                 customers:[],
                 transacts:'',
                 statusNew : this.status,
                 progress: this.initial,
                editmode: false,
                form: new Form({
                    id: '',
                    service:'',
                    status:'',
                    percent:'',
                    date:'',
                    weight:''
                })
            }
        },
        mounted(){
           if(this.$gate.customer()){
              this.getTransaction();
            /*  window.Echo.private('transaction-tracker.' + this.transaction_id)
            .listen('StatusChanged', (order) => {
              this.statusNew = order.status_name
              this.progress = order.status_percent
            });*/
           }
        },
        methods:{
             newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            viewTransact(transact){
                this.form.service = transact.service
                this.form.status = transact.status.name;
                this.form.percent = transact.status.percent
                this.form.date = transact.date_reserve
                this.form.weight = transact.weight
                $('#viewdetails').modal('show')
            },
            getTransaction(){
                axios.get('api/mytransaction').then(({data}) => this.transacts = data)
            },
            createTransaction(){
                this.form.post('api/transactions').then((response) => {
                    this.$Progress.start();
                     $('#addNew').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'Partial Reservation added into shop successfully'
                        })
                     this.$Progress.finish();
                })
            }
        }
        
    };
</script>