<?php
$conn = new mysqli("localhost", "root", "", "phonebook");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = $conn->real_escape_string($search); 
}


$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;


$count_sql = "SELECT COUNT(*) AS total FROM contacts 
              WHERE name LIKE '%$search%' 
              OR phone LIKE '%$search%' 
              OR email LIKE '%$search%'";
$count_result = $conn->query($count_sql);
$total_contacts = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_contacts / $limit);


$sql = "SELECT * FROM contacts 
        WHERE name LIKE '%$search%' 
        OR phone LIKE '%$search%' 
        OR email LIKE '%$search%'
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Phonebook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-5">

    <h2 class="text-center mb-4">Phonebook Manager</h2>

    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Add New Contact</div>
        <div class="card-body">
            <form action="save.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Upload Photo (Optional)</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary w-100">Save Contact</button>
            </form>
        </div>
    </div>

    
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search contacts..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-secondary">Search</button>
        </div>
    </form>

    
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow text-center">
                    <img src="<?= $row['photo'] ?: 'default.png' ?>" class="card-img-top" style="height:250px; object-fit:cover;">
                    <div class="card-body">
                        <h4><?= htmlspecialchars($row['name']) ?></h4>
                        <p>
                            <?= htmlspecialchars($row['phone']) ?><br>
                            <?= htmlspecialchars($row['email']) ?>
                        </p>

                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this contact?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    
    <nav>
        <ul class="pagination justify-content-center mt-4">

            
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
            </li>

            
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
            </li>

        </ul>
    </nav>

</div>


<script>
function validateForm() {
    let phone = document.getElementById("phone").value;

    if (!/^[0-9]+$/.test(phone)) {
        alert("Phone number must contain only digits!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
