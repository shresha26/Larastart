<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Drivers Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-driver-plus fa-fw"></i></button>
                </div>


              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Register At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="driver in drivers" :key="driver.id">
                      <td>{{driver.id}}</td>
                      <td>{{driver.name}}</td>
                      <td>{{driver.email}}</td>
                      <td>{{driver.created_at | myDate}}</td>

                      <td>
                            <a href="#" @click="editModal(driver)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deletedriver(driver.id)">
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
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update driver's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updatedriver() : createdriver()" >
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.email" type="email" email="email"
                        placeholder="Email Address"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                    <input v-model="form.password" type="password" name="password" id="password"
                    placeholder = "Password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
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
                drivers : {},
                form: new Form({
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio : ''
                })
            }
        },
        methods: {
            updatedriver(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/driver/'+this.form.id)
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
            editModal(driver){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(driver);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deletedriver(id){
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
                                    this.form.delete('api/driver/'+id).then(()=>{
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
            loaddrivers(){
                axios.get("api/driver").then(({data}) => (this.drivers = data.data));
            },

            createdriver(){
                this.$Progress.start();
                this.form.post('api/driver').then().catch(e => {console.log(e)})
                ;
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.$Progress.finish();

            }
        },
        created() {
            this.loaddrivers();
            Fire.$on('AfterCreate',() => {
                this.loaddrivers();
            });
        //  setInterval(() => this.loaddrivers(), 3000);
                }
    }
</script>
