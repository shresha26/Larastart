<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Buses Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-Bus-plus fa-fw"></i></button>
                </div>


              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Bus no</th>
                      <th>Bus color</th>
                      <th>Engine no</th>
                      <th>Mfd date</th>
                      <th>Company name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(Bus, index) in Buses" :key="index">
                      <td>{{Bus.id}}</td>
                      <td>{{Bus.busno}}</td>
                      <td>{{Bus.buscolor}}</td>
                      <td>{{Bus.engineno}}</td>
                      <td>{{Bus.mfddate}}</td>
                      <td>{{Bus.companyname}}</td>
                      <td>
                            <a href="#" @click="editModal(Bus)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteBus(Bus.id)">
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
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Bus's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateBus() : createBus()" >
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.busno" type="text" name="number"
                            placeholder="Bus Number"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('number') }">
                    <has-error :form="form" field="number"></has-error>
                    </div>
                     <div class="form-group">
                    <input v-model="form.buscolor"
                        placeholder="Bus Color"
                        name="buscolor"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('buscolor') }">
                    <has-error :form="form" field="buscolor"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.companyname"
                        placeholder="Company Name"
                        name="companyname"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('companyname') }">
                    <has-error :form="form" field="companyname"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.engineno"
                        placeholder="Bus Engine No:"
                        name="engineno"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('engineno') }">
                    <has-error :form="form" field="engineno"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.mfddate"
                        placeholder="Bus Manufacture Date"
                        name="mfddate"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('mfddate') }">
                    <has-error :form="form" field="mfddate"></has-error>
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
                Buses : {},
                form: new Form({
                    id:'',
                    busno: '',
                    buscolor: '',
                    engineno: '',
                    mfdate: '',
                    companyname : ''
                })
            }
        },
        methods: {
            updateBus(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/buses/'+this.form.id)
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
            editModal(Bus){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(Bus);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteBus(id){
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
                                    this.form.delete('api/buses/'+id).then(()=>{
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
            loadBuses(){
                axios.get("api/buses").then(({data})=>{
this.Buses = data.data
console.log("busses",this.Buses)
                }).catch();
            },

            createBus(){
                this.$Progress.start();
                this.form.post('api/buses');
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.$Progress.finish();
            }
        },
        created() {
            this.loadBuses();
            Fire.$on('AfterCreate',() => {
                this.loadBuses();
            });
        //  setInterval(() => this.loadBuses(), 3000);
                }
    }
</script>
