<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-bus-plus fa-fw"></i></button>
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Busid</th>
                      <th>Userid</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="bus in users" :key="bus.id">
                      <td>{{driver.id}}</td>
                      <td>{{driver.busid}}</td>
                      <td>{{driver.userid}}</td>
                      <td>
                            <a href="#" @click="editModal(bus)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteDriver(bus.id)">
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
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Driver's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateDriver() : createDriver()" >
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.id" type="text" id="id"
                            placeholder="Id"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                    <has-error :form="form" field="id"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.Busid" type="Busid" Busid="Busid"
                        placeholder="Email Address"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Busid') }">
                    <has-error :form="form" field="Busid"></has-error>
                </div>

                <div class="form-group">
                    <textarea v-model="form.Userid" type="Userid" Userid="Userid"
                    placeholder="Short.Userid for bus(Optional)"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('Userid') }"></textarea>
                    <has-error :form="form" field="Userid"></has-error>
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
                users : {},
                form: new Form({
                    id:'',
                    Busid: '',
                    Userid: ''
                })
            }
        },
        methods: {
            updateUser(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/bus/'+this.form.id)
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
            editModal(bus){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(bus);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteDriver(id){
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
                                    this.form.delete('api/bus/'+id).then(()=>{
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
            loadUsers(){
                axios.get("api/bus").then(({data}) => (this.users = data.data));
            },

            createUser(){
                this.$Progress.start();
                this.form.post('api/bus');
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.$Progress.finish();
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
                this.loadUsers();
            });
        //  setInterval(() => this.loadUsers(), 3000);
                }
    }
</script>
