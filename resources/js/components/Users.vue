<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add New &nbsp;<i class="fa fa-user-plus"></i></button>
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
                      <td>{{user.type}}</td>
                      <td>{{user.created_at}}</td>
                      <td>
                          <a href="#">
                              <i class="fa fa-user-edit blue"></i>
                          </a>
                          &nbsp;
                          <a href="#">
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
                        <h5 class="modal-title" id="addNewLabel">Add New</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form -->
                    <form @submit.prevent="createUser">
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
                          <input v-model="form.bio" type="text" name="bio" placeholder="Short bio for user (Optional)"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
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
                          <input v-model="form.password" type="password" name="password" id="Password" placeholder="Enter Password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                    
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Add</button>
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
          users : {},
          form: new Form({
            name: '',
            email: '',
            password: '',
            type: '',
            bio: ''
          })
        }
      },
      methods: {
        loadUsers() {
          axios.get('api/user')
            .then(({ data }) => (this.users = data.data));
        },

        createUser() {
          this.form.post('api/user');
        }
      },
        mounted() {
            this.loadUsers();
        }
    }
</script>
