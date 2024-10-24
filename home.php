<?php
session_start();
include 'db_conn.php'; // Ensure you have a working database connection here

// Query to fetch all users from the database
$query = "SELECT fname, username, password FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {
	?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div class="d-flex justify-content-center align-items-center vh-100">
			<div class="shadow w-450 p-4 text-center bg-light">
				<h3 class="display-4 mb-4">Hello, <?= $_SESSION['fname'] ?></h3>
				<a href="logout.php" class="btn btn-primary mb-4">
					Logout
				</a>
				<a href="about.php" class="btn btn-primary mb-4">
					About
				</a>

				<!-- Responsive Table for User Information -->
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th scope="col">First Name</th>
								<th scope="col">Username</th>
								<th scope="col">Password</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($users) > 0) {
								// Loop through all fetched users and display them in the table
								foreach ($users as $user) {
									echo "<tr>";
									echo "<td>" . htmlspecialchars($user['fname']) . "</td>";
									echo "<td>" . htmlspecialchars($user['username']) . "</td>";
									echo "<td>*******</td>"; // Masked password for security
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='3' class='text-center'>No users found</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</body>

	</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>