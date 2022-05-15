<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 
$errors1 = array();
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'usedart');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


 

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "اسم المستخدم مطلوب"); 
    }
  if (empty($email)) { array_push($errors, "البريد الالكتروني مطلوب"); 
   }
  if (empty($password_1)) { array_push($errors, "كلمة السر مطلوبة");
 }
  if ($password_1 != $password_2) {
	array_push($errors, "كلمة السر غير متطابقة");
  
  }
  if(strlen(trim($_POST["password_1"])) < 6){
    array_push($errors, "كلمة السر يجب ان تتكون من ستة رموز بحد ادنى.");}


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"البريد الالكتروني غير صالح");

      
      }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "اسم المستخدم موجود مسبقا");

    }

    if ($user['email'] === $email) {
      array_push($errors, "البريد الالكتروني مسجل مسبقا");

    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: my-account.php');
  }

  else{
  


      echo<<<HTML
    .
    .
    <script type="text/javascript">
    document.getElementById('id01').style.display='block';
    </script>
    HTML;
  }


}

// ... 


// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username1']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors1, "اسم المستخدم مطلوب");
    }
    if (empty($password)) {
        array_push($errors1, "كلمة السر مطلوبة");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        

        if (mysqli_num_rows($results) == 1) {
        
          $_SESSION['username'] = $username;
     
          $_SESSION['success'] = "You are now logged in";
          header('location: my-account.php');
        }else {
            array_push($errors1, "اسم المستخدم او كلمة السر غير صحيحة");
        }
    }
  }
  
  ?>