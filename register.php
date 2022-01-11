
<?php
 require_once "config.php";
 $username = $password = $confirm_password = "";
 $username_err = $password_err = $confirm_password_err = "";

 if ($_SERVER['REQUEST_METHOD'] == "POST"){

     // Check if username is empty
     if(empty(trim($_POST["username"]))){
         $username_err = "Username cannot be blank";
     }
     else{
         $sql = "SELECT id FROM users WHERE username = ?";
         $stmt = mysqli_prepare($conn, $sql);
         if($stmt)
         {
             mysqli_stmt_bind_param($stmt, "s", $param_username);

             // Set the value of param username
             $param_username = trim($_POST['username']);

             // Try to execute this statement
             if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                 {
                     $username_err = "This username is already taken"; 
                }
                 else{
                     $username = trim($_POST['username']);
                 }
             }
             else{
                 echo "Something went wrong";
             }
         }
     }

     mysqli_stmt_close($stmt);


 // Check for password
 if(empty(trim($_POST['password']))){
     $password_err = "Password cannot be blank";
 }
 elseif(strlen(trim($_POST['password'])) < 5){
     $password_err = "Password cannot be less than 5 characters";
 }
 else{
     $password = trim($_POST['password']);
 }

 // Check for confirm password field
 if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
     $password_err = "Passwords should match";
 }


//  If there were no errors, go ahead and insert into the database
 if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
 {
     $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
     $stmt = mysqli_prepare($conn, $sql);
     if ($stmt)
     {
         mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

         // Set these parameters
         $param_username = $username;
         $param_password = password_hash($password, PASSWORD_DEFAULT);

         // Try to execute the query
         if (mysqli_stmt_execute($stmt))
         {
             header("location: login.php");
         }
         else{
             echo "Something went wrong... cannot redirect!";
         }
     }
     mysqli_stmt_close($stmt);
 }
 mysqli_close($conn);
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <title>PHP login system!</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  
  <div class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 jumbotron text-white bg-dark vh-100" style="width: 280px;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">My Login</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="home.php" class="nav-link text-white" aria-current="page">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#home"></use>
            </svg>
            Home
          </a>
        </li>
        <li>
          <a href="register.php" class="nav-link active">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#speedometer2"></use>
            </svg>
            Register
          </a>
        </li>
        <li>
          <a href="login.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#table"></use>
            </svg>
            Login
          </a>
        </li>
        <li>
          <a href="logout.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#grid"></use>
            </svg>
            Logout
          </a>
        </li>
      </ul>
    </div>

    <div class="" style="width: calc(100% - 280px);">
      <div class="container">
        <div class='Register-form col-md-4 offset-md-4 bg-lite p-3'>
            <div class='jumbotron' style='margin-top:50px; padding-top:20px;'>
            <i class="fa fa-user icon"></i>
        
              <form method='post'>
        <h3>Register:</h3>
        <hr>
        <form action="" method="post">
          <div class="form-row row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Username</label>
              <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              <input type="password" class="form-control" name ="password" id="inputPassword4" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
              <label for="inputPassword4">Confirm Password</label>
              <input type="password" class="form-control" name ="confirm_password" id="inputPassword" placeholder="Confirm Password">
            </div>
          <div class="form-group">
            <label for="inputAddress2">Address 2</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
          </div>
          <div class="form-row row">
            <div class="form-group col-md-6">
              <label for="inputCity">City</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip">Zip</label>
              <input type="text" class="form-control" id="inputZip">
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        </div>
    </div>

  </div>



</body>

</html>

<style>
  .vh-100 {
    height: 100vh !important;
  }
  .jumbotron {
    padding: 2rem 1rem;
    margin-bottom: 2rem;
    background-color: #e9ecef;
    border-radius: .3rem;
  }
</style>