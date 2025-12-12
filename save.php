<?php
$conn = new mysqli("localhost", "root", "", "phonebook");

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$photoName = time() . "_" . $_FILES['photo']['name'];
$photoTmp = $_FILES['photo']['tmp_name'];

$dir = "uploads/";
if (!file_exists($dir)) mkdir($dir);

move_uploaded_file($photoTmp, $dir . $photoName);

$conn->query("INSERT INTO contacts (name, phone, email, photo)
VALUES ('$name', '$phone', '$email', '$dir$photoName')");

header("Location: index.php");
