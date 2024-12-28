<?php 
session_start();
include "koneksi.php";

if (isset($_SESSION['username'])) { 
	header("location:admin.php"); 
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["user"];
    $password = md5($_POST["pass"]);

    //prepared statement
    $stmt = $conn->prepare("SELECT username from user where username=? AND password=?");

    $stmt->bind_param("ss",$username,$password);

    $stmt->execute();
    $hasil=$stmt->get_result();
    $row = $hasil->fetch_array(MYSQLI_ASSOC);

    if(!empty($row)){
        $_SESSION['username'] = $row['username'];
        header("Location:admin.php");
    }else{
        header("Location:login.php");
    }
    $stmt->close();
    $conn->close();

}else{
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>

  <body class="bg-danger-subtle ">
    <div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card border-0 shadow rounded-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle h1 display-4"></i>
                        <p>Welcome</p>
                        <hr />
                    </div>
                    <form action="" method="post">
                        <input
                        type="text"
                        name="user"
                        class="form-control my-4 py-2 rounded-4"
                        placeholder="Username"
                        />
                        <input
                        type="password"
                        name="pass"
                        class="form-control my-4 py-2 rounded-4"
                        placeholder="Password"
                        />
                        <div class="text-center my-3 d-grid">
                        <button class="btn btn-danger rounded-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
  </body>
</html>
<?php } ?>
