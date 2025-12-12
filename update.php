<?php
$conn = new mysqli("localhost", "root", "", "phonebook");

$id = $_POST['id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$updatePhoto = "";

if (!empty($_FILES['photo']['name'])) {
    $newPhoto = "uploads/" . time() . "_" . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], $newPhoto);
    $updatePhoto = ", photo='$newPhoto'";
}

$sql = "UPDATE contacts SET 
        name='$name', 
        phone='$phone', 
        email='$email'
        $updatePhoto
        WHERE id=$id";

$conn->query($sql);

header("Location: index.php");
