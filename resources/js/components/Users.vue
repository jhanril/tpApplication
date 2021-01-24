<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Add New &nbsp;<i class="fa fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type | capitalize}}</td>
                      <td>{{user.created_at | dateFormat}}</td>
                      <td>
                          <a href="#" @click="editModal(user)">
                              <i class="fa fa-user-edit blue"></i>
                          </a>
                          &nbsp;
                          <a href="#" @click="deleteUser(user.id)">
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="editMode" class="modal-title" id="addNewLabel">Update User's Info</h5>
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form -->
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                      <div class="modal-body">
                        <div class="form-group">
                          <input v-model="form.name" type="text" name="name" placeholder="Enter Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                          <input v-model="form.email" type="email" name="email" placeholder="Enter Email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                          <textarea v-model="form.bio" name="bio" id="bio" placeholder="Short bio for user (Optional)"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                          <has-error :form="form" field="bio"></has-error>
                        </div>
                        
                        <div class="form-group">
                          <select v-model="form.type" id="type" type="text" name="type" class="form-control" 
                          :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                          </select>
                          <has-error :form="form" field="type"></has-error>
                        </div>
                        
                        <div class="form-group">
                          <input v-show="editMode" v-model="form.password" type="password" name="password" id="editPassword"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <input v-show="!editMode" v-model="form.password" type="password" name="password" id="Password" placeholder="Enter Password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                    
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                          <button v-show="!editMode" type="submit" class="btn btn-primary">Add</button>
                      </div>
                  </form>
                  <!-- Form end-->
                </div>
            </div>
        </div>
         <!-- Modal end -->
    </div>
</template>

<script>
    export default {
      data() {
        return {
          editMode: false,
          users : {},
          form: new Form({
            id: '',
            name: '',
            email: '',
            password: '',
            type: '',
            bio: ''
          })
        }
      },

      methods: {
        updateUser(){
          this.$Progress.start();
          // console.log('Clicked');
          this.form.put('api/user/'+this.form.id)
          .then(() => {

            $('#addNew').modal('hide');

              Swal.fire(
                'Updated!',
                'User info has been updated',
                'success'
              )
              this.$Progress.finish();
              Fire.$emit('loadData');
          })
          .catch(() => {
            this.$Progress.fail();
          });
        },

        editModal(user) {
          this.editMode = true;
          this.form.clear();
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
        },

        newModal() {
          this.editMode = false;
          this.form.clear();
          this.form.reset();
          $('#addNew').modal('show');
        },
        
        loadUsers() {
          axios.get('api/user')
            .then(({ data }) => (this.users = data.data));
        },

        deleteUser(id){
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {

                    // Send request to server
                    this.form.delete('api/user/'+id).then(() =>{

                        Swal.fire(
                          'Deleted!',
                          'User has been deleted.',
                          'success'
                        )
                        Fire.$emit('loadData');

                    }).catch(() => {
                      Swal.fire(
                          'Failed!',
                          'There was something wrong.',
                          'warning'
                      )
                    })
                  }
                })
        },

        createUser() {
          this.$Progress.start();
          this.form.post('api/user')
          .then( () => {

            // this.loadUsers(); ##use below instead
            Fire.$emit('loadData');

            $('#addNew').modal('hide')

            Toast.fire({
              icon: 'success',
              title: 'Signed in successfully'
            })
            this.$Progress.finish();

          })
          .catch(() => {} )

          
        }
      },
        mounted() {
            this.loadUsers();
            Fire.$on('loadData', () => {
              this.loadUsers();
            })
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
