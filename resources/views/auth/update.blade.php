<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
body {
  font-family: Arial, Helvetica, sans-serif;
  /* background-color: black; */
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
.button {
  background-color: #008CBA; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 24px;
}
</style>
</head>
<body>
<h2 style="margin-left: 26%;">Update profile</h2>
<?php //echo '<pre>'; print_r($user_details) ?>
<form action="{{ route('update' , $user_details->id) }}" method="post">
    @csrf
    @method('post')
  <div class="container" style="width: 40%; margin-left: 25%;">
  <input type="hidden" placeholder="Enter Username" name="id" value="{{ $user_details->id }}" required >
    <label for="uname"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" value="{{ $user_details->name }}" required >

    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" value="{{ $user_details->email }}" required >

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password"  required >
        
    <button type="submit" value="login" class="button">Update</button>
  </div>

</form>
</body>
</html>