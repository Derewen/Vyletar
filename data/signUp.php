<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];

    $emailSelect = $db->prepare("SELECT EMAIL FROM USERS WHERE EMAIL = ? LIMIT 1");
    $emailSelect->execute(array($email));
    $existingUser = $emailSelect->fetchColumn();
    if ($existingUser != null) {
        echo "<div style='text-align: center; margin-top:220px;'>
                        <label id='warningLb'>
                            Email already in use.
                        </label>
                      </<div>";
    } else {
        //hash
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        //insert
        $stmt = $db->prepare("INSERT INTO USERS(name, surname, password, email) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($name, $surname, $hashed, $email));
        //session id
        $stmt = $db->prepare("SELECT USER_NUMBER FROM USERS WHERE EMAIL = ? LIMIT 1");
        $stmt->execute(array($email));
        $user_number = (int) $stmt->fetchColumn();
        $_SESSION["user_id"] = $user_number;
        //redirect
        header("Location: ../index.php");
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Výletář</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
  </head>
  <body>
    <div class="logo">
      <img src="../resources/TripOut.png" alt="Logo" height="129" width="489">
    </div>
    <div class="login">
      <form method="POST">
        <input
            type="email"
            name="email" id="email"
            placeholder="Email"
            required="required"
            />
        <input
            type="text"
            name="name" id="name"
            placeholder="Jméno"
            required="required"
            />
        <input
            type="text"
            name="surname" id="surname"
            placeholder="Příjmení"
            required="required"
            />
        <input
            type="password"
            name="password" id="password"
            placeholder="Heslo"
            required="required"
            />
        <input
            type="submit" id="submit" value="Registruj!"
            />
        <input type="button"
             value="Zpět"
             onclick="location.href='../index.php'"
             id="cancelBtn"
             />
      </form>
    </div>
  </body>
</html>

