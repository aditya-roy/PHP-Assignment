<?php
require("connect.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <title>Bootstrap Elegant Sign Up Form with Icons</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
$successMessage = $errorMessage = null;
$name = $email = $password = $confirmpassword = "";

if (isset($_POST['submit'])) {
  $check = 1;

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["name"])) {
      $name = test_input($_POST["name"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errorMessage = "Only letters and white space allowed";
        $check = 0;
      }
    }

    if (!empty($_POST["email"])) {
      $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format";
        $check = 0;
      }
    }

    if ($_POST['password'] != $_POST['confirmpassword']) {
      $errorMessage = "Password and Confirm Password doesn't match";
      $check = 0;
    }

    if (empty($_POST["agree"])) {
      $errorMessage = "Please check the check box";
      $check = 0;
    }

    if ($check == 1) {
      $q = "insert into signup(name,email,password) values('" . $_POST['name'] . "','" . $_POST['email'] . "','" . $_POST['password'] . "')";
      $n = mysqli_query($con, $q);
      if (!$n) {
        $errorMessage = "Sign Up Failed!";
      } else {
        $successMessage = "Sign Up Successful!";
        $name = $email = $password = $confirmpassword = "";
      }
    }
  }
}
?>

<body>
  <div class="center-div">
    <div class="signup-form">
      <form action="" method="post">
        <h2>Create Account</h2>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Enter Name" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Enter Email Address" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 6 or more characters" name="password" value="<?php echo $password; ?>" placeholder="Password" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-lock"></i>
              <i class="fa fa-check"></i>
            </span>
            <input type="password" class="form-control" name="confirmpassword" value="<?php echo $confirmpassword; ?>" placeholder="Confirm Password" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="checkbox" name="agree" value="checked" /> I agree the term of use & Privacy Policy<br />
          </div>
        </div>
        <?php echo $successMessage !== null ? '<div class="alert alert-success" role="alert">' . $successMessage . '</div>' : null ?>
        <?php echo $errorMessage !== null ? '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>' : null ?>

        <div class="form-group">
          <input type="submit" value="Sign Up" name="submit" class="btn btn-primary btn-block btn-lg" />
        </div>
      </form>
    </div>
  </div>

</body>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 4000);
</script>

</html>