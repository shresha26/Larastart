<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">transactions Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-transaction-plus fa-fw"></i></button>
                </div>


              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>from_account</th>
                      <th>to_account</th>
                      <th>type</th>
                      <th>Status</th>
                      <th>Amount</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(transaction, index) in transactions" :key="index">
                      <td>{{transaction.id}}</td>
                      <td>{{transaction.from_account}}</td>
                      <td>{{transaction.to_account}}</td>
                      <td>{{transaction.type}}</td>
                      <td>{{transaction.status}}</td>
                      <td>{{transaction.amount}}</td>
                      <td>
                            <a href="#" @click="editModal(transaction)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deletetransaction(transaction.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update transaction's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updatetransaction() : createtransaction()" >
                <div class="modal-body">
                    <div class="form-group">
                        <label>From User</label>
                        <select class="form-control" v-model="form.from_account">
                          <option value="" disabled>Please Select From  User</option>
                          <option :value="item.id"  v-for="(item,index) in userLists" :key="index">{{item.name}}</option>
                        </select>
                      </div>
                    <div class="form-group">
                        <label>To User</label>
                        <select class="form-control" v-model="form.to_account" >
                          <option value="" disabled>Please Select To User</option>
                          <option :value="item.id" v-for="(item,index) in receiverList" :key="'to'+index">{{item.name}}</option>
                        </select>
                    <has-error :form="form" field="to_account"></has-error>
                    </div>
                 <div class="form-group">
                    <input v-model="form.type"
                        placeholder="type"
                        name="type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <has-error :form="form" field="type"></has-error>
                </div>
                 <!-- <div class="form-group">
                    <input v-model="form.remarks"
                        placeholder="remarks"
                        name="remarks"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('remarks') }">
                    <has-error :form="form" field="remarks"></has-error>
                </div> -->
                 <div class="form-group">
                    <input v-model="form.status"
                        placeholder="status"
                        name="status"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                    <has-error :form="form" field="status"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model.number="form.amount"
                        placeholder="Amount"
                        name="amount"
                        type="number"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                    <has-error :form="form" field="amount"></has-error>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="editmode" type= "submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>
                </div>
            </div>
            </div>
    </div>


</template>

<script>
    import Axios from "axios"
    export default {
        data(){
            return{
                editmode: false,
                transactions : [],
                userLists : [],
                form: new Form({
                    id:'',
                    from_account: '',
                    to_account: '',
                    type: '',
                    remarks: '',
                    amount: '',
                    status : ''
                })
            }
        },
        computed: {
            receiverList() {
                return this.userLists.filter(item=>item.id !== this.form.from_account);
            }
        },
        methods: {
            updatetransaction(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/transactions/'+this.form.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                     Swal.fire(
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

            },
            editModal({...transaction}){
                transaction.from_account = transaction.from_account_id
                transaction.to_account = transaction.to_account_id
                console.log('transaction',transaction)
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(transaction);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deletetransaction(id){
                   Swal.fire({
                         title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {

                            //send request to the server
                            if (result.value){
                                    this.form.delete('api/transactions/'+id).then(()=>{
                                            Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                            )
                                            Fire.$emit('AfterCreate');
                                        }).catch(()=>{
                                        Swal("Failed", "There was something wrong.", "warning");
                                    });
                            }
                        })
                    },
           async loadtransactions(){
               const {data} = await Axios.get("api/transactions")
               this.transactions = data.data
            },

            createtransaction(){
                this.$Progress.start();
                this.form.post('api/transactions');
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.$Progress.finish();
            },
           async  getUsersList(){
               const {data} = await Axios.get('api/usersList')
               this.userLists = data.data

            }
        },
        created() {
            this.loadtransactions();
            this.getUsersList();
            Fire.$on('AfterCreate',() => {
                this.loadtransactions();
            });
        //  setInterval(() => this.loadtransactions(), 3000);
                }
    }
</script>
