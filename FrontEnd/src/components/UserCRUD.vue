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
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in posts" :key="post.id">
          <td scope="row">{{post.id}}</td>
          <td>{{post.first_name}}</td>
          <td>{{post.last_name}}</td>
          <td>{{post.DOB}}</td>
          <td>{{post.gender}}</td>
          <td><a href="#" class="btn btn-warning" @click="get_user(post.id,post.first_name,post.last_name,post.DOB,post.gender)">Edit</a> <a href="#"  class="btn btn-danger" @click="delete_user(post.id)">Delete</a></td>
         
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
      <input type="date" name="DOB" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="form.DOB">
    </div>
    <select v-model="form.gender" name="gender">
        <option disabled value="">Please select one</option>
        <option value="male">Male</option>
        <option value="female">FeMale</option>
     </select> 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<div class="col-md-12" v-if="edituser">
    <h2>Edit User</h2>
    <form v-on:submit.prevent="update(upd_user.id)">
      <div class="form-group">
    <label for="first_name">Enter First name</label>
    <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" v-model="upd_user.first_name">
   </div>
     <div class="form-group">
    <label for="last_name">Enter Last Name</label>
    <input type="text" name="last_name" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="Enter Email" v-model="upd_user.last_name">
    <input type="hidden" name="id" v-model="upd_user.id">
    </div>
    <div class="form-group">
    <label for="email">Enter Gender</label>
    <input type="date" name="DOB" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" v-model="upd_user.DOB">
    <!-- <input type="hidden" name="id" v-model="upd_user.id"> -->
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
      first_name: '',
      last_name: ''
      
    },
    upd_user:{
      id:null,
      first_name:'',
      last_name :'',
      DOB : '',
    },
  }
},
methods:{
  //getting all users details
  loadlist(){
    axios
      .get('http://127.0.0.1:8000/api/User/all')
      .then((resp) => {
        console.log(resp.data.data);
        this.posts = resp.data.data;
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
         this.form.first_name = '';
         this.form.last_name = '';
         this.form.DOB = '';
         this.form.gender = '';
      })
      .catch((e)=>{
          console.log(e);
      })
    },
   //get user dtails to show inside edit form
   get_user(id,first_name,last_name,DOB){
      
      this.edituser = true,
      this.adduser = false
      this.upd_user.id = id;
      this.upd_user.first_name = first_name;
      this.upd_user.last_name = last_name;
      this.upd_user.DOB = DOB;

    },
    //update user
    update(id){
      axios
      .post('http://127.0.0.1:8000/api/User/update/'+id)
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
      axios.delete('http://127.0.0.1:8000/api/User/delete/'+deleteid)
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