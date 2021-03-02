<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">TopUp Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-topup-plus fa-fw"></i></button>
                </div>


              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Code</th>
                      <th>Amount</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="topup in topups" :key="topup.id">
                      <td>{{topup.id}}</td>
                      <td>{{topup.code}}</td>
                      <td>{{topup.amount}}</td>
                      <td>{{topup.status}}</td>

                      <td>
                            <a href="#" @click="editModal(topup)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deletetopup(topup.id)">
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
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update TopUp's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updatetopup() : createtopup()" >
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.id" type="text" name="id"
                            placeholder="ID"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                    <has-error :form="form" field="id"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.code" type="code" name="code"
                        placeholder="Code"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                    <has-error :form="form" field="code"></has-error>
                </div>

                <div class="form-group">
                    <input v-model="form.amount" type="amount" name="amount"
                    placeholder = "Amount"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                    <has-error :form="form" field="amount"></has-error>
                    </div>

                 <div class="form-group">
                    <input v-model="form.status" type="status" name="status"
                    placeholder = "Status"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                    <has-error :form="form" field="status"></has-error>
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
    export default {
        data(){
            return{
                editmode: false,
                topups : {},
                form: new Form({
                    id:'',
                    code: '',
                    amount: '',
                    status: ''
                })
            }
        },
        methods: {
            updatetopup(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/topup/'+this.form.id)
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
            editModal(topup){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(topup);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deletetopup(id){
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
                                    this.form.delete('api/topup/'+id).then(()=>{
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
            loadtopups(){
                axios.get("api/topup").then(({data}) => (this.topups = data.data));
            },

            createtopup(){
                this.$Progress.start();
                this.form.post('api/topup').then().catch(e => {console.log(e)})
                ;
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.$Progress.finish();

            }
        },
        created() {
            this.loadtopups();
            Fire.$on('AfterCreate',() => {
                this.loadtopups();
            });
        //  setInterval(() => this.loadtopups(), 3000);
                }
    }
</script>
