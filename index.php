<?php
// index.php

// Include the database connection and fetch students logic
require_once __DIR__ . '/src/database.php'; // Ensure database connection is included

// Fetch students
$students = [];
if ($mysqli) {
    $stmt = $mysqli->query("SELECT * FROM students");
    if ($stmt) {
        $students = $stmt->fetch_all(MYSQLI_ASSOC);
    } else {
        error_log('Error fetching students: ' . $mysqli->error);
    }
} else {
    error_log('Database connection failed!');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="src/create.php">Add Student</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Student Management System</h2>

        <!-- Display Error Message if DB is not connected -->
        <?php if (empty($students)): ?>
            <div class="alert alert-warning mt-4">
                Database connection failed or no students found.
            </div>
        <?php endif; ?>

        <!-- Student Table -->
        <h3 class="mt-5">Student List</h3>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Student Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Program</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['num']); ?></td>
                        <td><?php echo htmlspecialchars($student['nom']) . ' ' . htmlspecialchars($student['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['filiere']); ?></td>
                        <td>
                            <a href="src/update.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Trigger Modal for Delete -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-student-id="<?php echo $student['id']; ?>" data-student-name="<?php echo htmlspecialchars($student['nom'] . ' ' . $student['prenom']); ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the student <strong id="studentName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="deleteBtn" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Get references to the modal elements
        const deleteModal = document.getElementById('deleteModal');
        const studentNameElement = document.getElementById('studentName');
        const deleteBtn = document.getElementById('deleteBtn');

        // Add event listener for modal show event to set student info
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const studentId = button.getAttribute('data-student-id');
            const studentName = button.getAttribute('data-student-name');
            
            // Update the modal content
            studentNameElement.textContent = studentName;
            deleteBtn.href = `src/delete.php?id=${studentId}`;
        });
    </script>
</body>
</html>
