<?php
$conn = new mysqli("localhost", "root", "", "phonebook");
$id = $_GET['id'];

$data = $conn->query("SELECT * FROM contacts WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
<div class="container py-5">

    <h2>Edit Contact</h2>

    <form action="update.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= $data['phone'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Change Photo (optional)</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>

    </form>

</div>
</body>
</html>
