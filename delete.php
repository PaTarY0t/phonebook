<?php
$conn = new mysqli("localhost", "root", "", "phonebook");
$id = $_GET['id'];

$conn->query("DELETE FROM contacts WHERE id=$id");

header("Location: index.php");
