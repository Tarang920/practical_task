<template>
    <div class="container mb-5 mt-5">
      <div class="row">
      <div class="col-md-12 bg-light p-5 mb-5">
      <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">FirstName</th>
          <th scope="col">LastName</th>
          <th scope="col">DOB</th>
          <th scope="col">Gender</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in posts" :key="post.id">
          <td scope="row">{{post.id}}</td>
          <td>{{post.name}}</td>
          <td>{{post.email}}</td>
          <td><a href="#" class="btn btn-warning" @click="get_user(post.id,post.name,post.email)">Edit</a> <a href="#"  class="btn btn-danger" @click="delete_user(post.id)">Delete</a></td>
         
        </tr>
      </tbody>
    </table>
</div>
<div class="col-md-12" v-if="adduser">
    <h2>Create User Here</h2>
    <form v-on:submit.prevent="create_user">
      <div class="form-group">
    <label for="name">Enter First name</label>
    <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" v-model="form.first_name">
   </div>
    <div class="form-group">
      <label for="lname">Enter Last Name</label>
      <input type="text" name="last_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="form.last_name">
    </div>
   <div class="form-group">
      <label for="dob">Enter DOB</label>
      <input type="text" name="DOB" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="form.DOB">
    </div>
    <div class="form-group">
      <label for="name">Enter Gender</label>
      <input type="text" name="gender" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="form.gender">
    </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<div class="col-md-12" v-if="edituser">
    <h2>Edit User</h2>
    <form v-on:submit.prevent="update(upd_user.id)">
      <div class="form-group">
    <label for="name">Enter name</label>
    <input type="text" name=" name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" v-model="upd_user.name">
   </div>
     <div class="form-group">
    <label for="email">Enter Email</label>
    <input type="email" name=" email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="upd_user.email">
    <input type="hidden" name="id" v-model="upd_user.id">
    </div>
   
 
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>
</div>
    </div>
<div class="jumbotron text-center mb-0">
  <p>Footer</p>
  
</div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from 'axios'
export default {
mounted () {
    //getting user data
    this.loadlist();
  },
data(){
  return {
    posts:[],
    edituser:false,
    adduser:true,
    form:{
      name: '',
      email: ''
      
    },
    upd_user:{
      id:null,
      name:'',
      email:'',
    },
  }
},
methods:{
  //getting all users details
  loadlist(){
    axios
      .get('http://127.0.0.1:8000/users')
      .then((resp) => {
        console.log(resp);
        this.posts = resp.data;
      })
    },
  //add new user
  create_user(){
    
      axios
      .post('http://127.0.0.1:8000/api/User/create',this.form)
      .then((resp) =>{
          console.log(resp);
          this.loadlist();
          //reset form
         this.form.name = '';
         this.form.email = '';
      })
      .catch((e)=>{
          console.log(e);
      })
    },
   //get user dtails to show inside edit form
   get_user(id,name,email){
      
      this.edituser = true,
      this.adduser = false
      console.log(id,name,email);
      this.upd_user.id = id;
      this.upd_user.name = name;
      this.upd_user.email = email;
    },
    //update user
    update(id){
      console.log(id);
      axios
      .post('http://127.0.0.1:8000/api/User/update'+id,this.upd_user )
      .then((resp) =>{
          console.log(resp);
           this.edituser = false,
          this.adduser = true
          this.loadlist();
          
          
      })
      .catch((e)=>{
          console.log(e);
      })
    },
    //delete user
    delete_user(deleteid){
      axios.delete('http://127.0.0.1:8000/api/User/delete'+deleteid)
      .then((res) =>{
        console.log(res);
        this.loadlist();
      })
      .catch((e)=>{
        console.log(e);
      })
    }
},
}
</script>