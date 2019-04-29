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
                                    
                                    <div class="col p-r-0">
                                        <h3>Price: P<span style="font-size:19px;">{{transact.service.price}}</span> <span style="font-size:12px;">/kilo</span></h3>
                                        <h4 class="font-light">Php{{transact.total}}</h4>
                                        <h6 class="text-muted">{{transact.service.servicetype}}</h6>
                                        <span class="label label-primary">{{transact.status.name}}</span>
                                    </div>
                                    <!-- Column -->
                                    <div class="col text-right align-self-center">
                                        <v-progress-circular
                                          :rotate="270"
                                          :size="100"
                                          :width="15"
                                          :value="transact.status.percent"
                                          color="pink"
                                        >
                                         {{transact.status.percent}}
                                        </v-progress-circular>
 
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
                            <input @change="checkDate()" id="datepicker" type="date" data-date-format="yyyy-mm-dd" name="date" v-model="form.date" class="form-control" :class="{'is-invalid': form.errors.has('date') }">
                            <has-error :form="form" field="date"></has-error>
                            <br><br>
                            <select name="service"  v-model="form.service" class="form-control" required :class="{'is-invalid': form.errors.has('service') }">
                                <option value="" disabled selected>--Choose service --</option>
                                <option v-for="service in services" :value="service.id">{{service.servicetype}}</option>
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
                                <h5 style="display:inline;"><b>Service :</b> </h5><span style="display:inline;color:indigo;"><b> {{form.servicetype}}</b></span>
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
                 services:[],
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
                    weight:'',
                    servicetype:'',
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
            this.viewService()

           }
        },
        methods:{
             newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            viewService(){
              axios.get('api/services').then(({data}) => this.services = data);
            },
            viewTransact(transact){
                this.form.servicetype = transact.service.servicetype
                this.form.status = transact.status.name;
                this.form.percent = transact.status.percent
                this.form.date = transact.date_reserve
                this.form.weight = transact.weight
                $('#viewdetails').modal('show')
            },
           checkDate() {
              var selectedText = document.getElementById('datepicker').value;
              var selectedDate = new Date(selectedText);
              var now = new Date();
              if (selectedDate < now) {
               alert("Date must be in the future");
            }
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