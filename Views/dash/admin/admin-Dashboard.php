<?php
include '../../../Models/addNew-User.php';
include '../../../Controllers/manage-Books-Admin.php';
// session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../auth/login-Register-Page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management System</title>
    <link rel="stylesheet" href="../../../assets/styles/dash/admin-Dashboard-Style.css" />

</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h2>📚 Library Management System</h2>
                <p>Administrator Dashboard</p>
            </div>
            <div class="admin-info">
                <div class="admin-avatar">SA</div>
                <div>
                    <strong>Welcome, <span style="color:#1B56FD"><?= $_SESSION['name']; ?></span>!</strong><br/>
                    <small>Administrator</small>
                </div>
                <button class="logout-btn" 
                onclick="window.location.href='../../../Controllers/auth/logout.php'">Logout</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <?php
        // Get user statistics
        $total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role!='admin'"));
        // $total_admins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='admin'"));
        $total_librarians = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='librarian'"));
        $total_students = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='student'"));

        $total_books = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM books WHERE id"));
        ?>
            <div class="stat-card users">
                <div class="stat-number"><?php echo $total_users;?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card books">
                <div class="stat-number"><?php echo $total_students;?></div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card issued">
                <div class="stat-number"><?php echo $total_librarians;?></div>
                <div class="stat-label">Total Librarians</div>
            </div>
            <!-- <div class="stat-card overdue">
                <div class="stat-number" id="overdueBooks"></div>
                <div class="stat-label">Total Admins</div>
            </div> -->
            <div class="stat-card books">
                <div class="stat-number"><?php echo $total_books;?></div>
                <div class="stat-label">Total Books</div>
            </div>
        </div>

    <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab" onclick="showSection('circulation')">🏠 Home</button>
            <button class="nav-tab" onclick="showSection('books')">📚 Manage Books</button>
            <button class="nav-tab active" onclick="showSection('manageUsers')">👥 Manage Users</button>
            <button class="nav-tab" onclick="showSection('settings')">⚙️ Settings</button>
        </div>

        <!-- Circulation Section -->
        <div id="circulation" class="content-section ">
            <!-- ... (your existing code for circulation section) active ... -->
            
        </div>

        <!-- Books Management Section -->
        <div id="books" class="content-section">
            <div id="bookSection" style="height: 80vh; overflow-y: auto;">
            <div>
                <button class="btn" 
                onclick="showAddBookForm()" 
                style="margin-bottom: 15px;">
                    Add New Book
                </button>
            </div>

            <h2 style="margin-bottom: 10px;">Manage Books</h2>

            <!-- Wrapper -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0;">

                <!-- Search Container -->
                <div class="search-container" style="display: flex; align-items: center; gap: 10px;">
                    <input type="text" class="search-input" id="searchBookInput" 
                           placeholder="Search by title, author, or category..." 
                           style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           onkeyup="searchBooks()">
                    <button class="btn-search" onclick="searchBooks()" 
                            style="padding: 8px 12px;">Search</button>
                </div>

                <!-- Filter Container -->
                <div class="filter-container" style="display: flex; align-items: center; gap: 10px;">
                    <label for="categoryFilter" style="font-weight: bold;">Filter by Category:</label>
                    <select id="categoryFilter" class="category-dropdown" onchange="filterByCategory()" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                        <option value="all">All Books</option>
                        <option value="CS">CS</option>
                        <option value="CSE">CSE</option>
                        <option value="EEE">EEE</option>
                        <option value="BBA">BBA</option>
                    </select>
                    <button class="btn-reset" onclick="resetBookFilters()" 
                            style="padding: 8px 12px;">Reset</button>
                </div>

            </div>

            <!-- Books Table -->
            <table id="booksTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Available Copies</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody id="bookTableBody">
                    <?php
                    $display_books = "SELECT * FROM books ORDER BY id DESC";
                    $result_books = mysqli_query($conn, $display_books);
                    if(mysqli_num_rows($result_books) > 0) {
                        while($row = mysqli_fetch_assoc($result_books)) {
                            echo "<tr class='book-row' data-category='" . strtolower($row['category']) . "'>";
                            echo "<td><strong>#" . sprintf("%03d", $row['id']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['copies']) . "</td>";
                            echo "<td>";
                            echo "<div class='operation-buttons'>";
                            echo "<button class='btnE btnEdit' onclick='editBook(" . $row['id'] . ", \"" . htmlspecialchars(addslashes($row['title'])) . "\", \"" . htmlspecialchars(addslashes($row['author'])) . "\", \"" . htmlspecialchars(addslashes($row['category'])) . "\", " . $row['copies'] . ")'> Edit</button>";
                            echo "<button class='btnE btnDelete' onclick='deleteBook(" . $row['id'] . ", \"" . htmlspecialchars(addslashes($row['title'])) . "\")'> Delete</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center; padding: 30px; color: #666;'> No books found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Edit Book Modal -->
            <div id="editBookModal" class="modal" style="display: none;">
                <div class="modalContent">
                    <span class="close" onclick="closeEditBookModal()">&times;</span>
                    <h3>Edit Book</h3>
                    <form action="" method="post" id="editBookForm">
                        <input type="hidden" name="edit_book_id" id="edit_book_id">

                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" name="edit_title" id="edit_title" required>
                        </div>

                        <div class="form-group">
                            <label>Author:</label>
                            <input type="text" name="edit_author" id="edit_author" required>
                        </div>

                        <div class="form-group">
                            <label>Category:</label>
                             <select name="edit_category" id="edit_category" required>
                                <option value="CS">CS</option>
                                <option value="CSE">CSE</option>
                                <option value="EEE">EEE</option>
                                <option value="BBA">BBA</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Available Copies:</label>
                            <input type="number" name="edit_copies" id="edit_copies" min="1" required>
                        </div>

                        <input type="submit" id="editBookBtn" value="Update Book">
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Book Form -->
        <div class="form-container" id="addBookSection" style="display:none;">
            <button class="logout-btn back-button" type="button" onclick="showManageBooks()">Back</button>
            <form action="" method="post" id="bookForm">

<div class="addBookSection">
                    <h3 style="color:green">Add New Book</h3>
                <div class="form-row-ab">
                    <div>
                        <label>Title:</label>
                        <input type="text" name="title" placeholder="Enter book title" required>
                    </div>
                    <div>
                        <label>Author:</label>
                        <input type="text" name="author" placeholder="Enter author name" required>
                    </div>
                </div>
                <div class="form-row-ab">
                    <div>
                        <label>Category:</label>
                        <!-- <input type="text" name="category" placeholder="Enter category" required> -->
                        <select name="category" id="" required>
                            <option value="CS">CS</option>
                            <option value="CSE">CSE</option>
                            <option value="EEE">EEE</option>
                            <option value="BBA">BBA</option>
                        </select>
                    </div>
                    <div>
                        <label>Available Copies:</label>
                        <input type="number" name="copies" placeholder="Enter number of copies" required min="1">
                    </div>
                </div>
                <input type="submit" value="Add Book">
            </form>
</div>
        </div>
        </div>


<!-- Manage Users & Fines Section -->
<div id="manageUsers" class="content-section active">
    
    <!-- User List -->
    <div id="userSection" style="height: 80vh; overflow-y: auto;">
        <div>
            <button class="btn" 
            onclick="showRegisterForm()" 
            style="margin-bottom: 15px;">
                Add New User
            </button>
        </div>
        <h2 style="margin-bottom: 10px;">Manage Users</h2>
            
<!-- Wrapper -->
<div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0;">

    <!-- Search Container -->
    <div class="search-container" style="display: flex; align-items: center; gap: 10px;">
        <input type="text" class="search-input" id="searchInput" 
               placeholder="Search by name, email, or role..." 
               style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        <button class="btn-search" onclick="searchTable()" 
                style="padding: 8px 12px;">Search</button>
    </div>

    <!-- Filter Container -->
    <div class="filter-container" style="display: flex; align-items: center; gap: 10px;">
        <label for="roleFilter" style="font-weight: bold;">Filter by Role:</label>
        <select id="roleFilter" class="role-dropdown" onchange="filterByRole()" 
                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; background: white;">
            <option value="all">All Users</option>
            <option value="student">Student</option>
            <option value="librarian">Librarian</option>
            <!-- <option value="admin">Admin</option> -->
        </select>
        <button class="btn-reset" onclick="resetFilters()" 
                style="padding: 8px 12px;">Reset</button>
    </div>

</div>

        <!-- Users Table -->
        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php
                $display_sql = "SELECT * FROM all_users ORDER BY id DESC";
                $result = mysqli_query($conn, $display_sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($row['role'] !== 'admin') {
                        echo "<tr class='user-row' data-role='" . $row['role'] . "'>";
                        echo "<td><strong>#" . sprintf("%03d", $row['id']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td><span class='role-badge role-" . $row['role'] . "'>" . ucfirst($row['role']) . "</span></td>";
                        echo "<td>";
                        echo "<div class='operation-buttons'>";
                        if ($row['role'] !== 'admin') {
                             echo "<button class='btnE btnEdit' onclick='editUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\",
                         \"" . addslashes($row['email']) . "\", \"" . $row['role'] . "\")'> Edit</button>";
                        } else {
                            echo "<button class='btnE btnProtected' title=' Admin - Cannot be Edited'> Protected</button>";
                        }
                        
                        if ($row['role'] !== 'admin') {
                            echo "<button class='btnE btnDelete' onclick='deleteUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\")'> Delete</button>";
                        } else {
                            echo "<button class='btnE btnProtected' title='Super Admin - Cannot be deleted'> Protected</button>";
                        }
                        
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center; padding: 30px; color: #666;'> No users found</td></tr>";
                }
                ?>
            </tbody>
        </tbody>
    </table>


    <!-- Edit User Modal -->
<div id="editModal" class="modal">
    <div class="modalContent">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit User </h3>
        <form action="" method="post" id="editForm">
            <input type="hidden" name="edit_id" id="edit_id">

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="edit_name" id="edit_name" required>
                <span id="editNameError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="edit_email" id="edit_email" required>
                <span id="editEmailError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>Password (Leave blank to keep current):</label>
                <input type="password" name="edit_password" id="edit_password" minlength="6">
                <small style="color: #666; font-size: 12px;">Only enter if you want to change the password</small>
                <span id="editPasswordError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>User Role:</label>
                <select name="edit_role" id="edit_role" required>
                    <option value="">Select Role</option>
                    <!-- <option value="admin">Admin</option> -->
                    <option value="librarian">Librarian</option>
                    <option value="student">Student</option>
                </select>
                <span id="editRoleError" class="error-message" style="color:red;"></span>
            </div>

            <input type="submit" id="editUserBtn" value=" Update User">
        </form>
    </div>
 </div>
</div>
<!-- Add User Form -->
    <div class="form-container" id="addUserSection" style="display:none;">
        <button class="logout-btn back-button" type="submit" onclick="showManageUsers()">Back</button>
        <form action="" method="post" id="userForm">
            <h3>Add New User</h3>
    <div class="form-row">
        <div>
            <label>Full Name:</label>
            <input type="text" name="name" placeholder="Enter full name" required>
            <span class="error" id="nameError"></span>
        </div>
        <div>
            <label>Email Address:</label>
            <input type="email" name="email" placeholder="Enter email address" required>
            <span class="error" id="emailError"></span>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required minlength="6">
            <span class="error" id="passwordError"></span>
        </div>
        <div>
            <label>User Role:</label>
            <select name="role" required>
                <option value="">Select Role</option>
                <!-- <option value="admin">Admin</option> -->
                <option value="librarian">Librarian</option>
                <option value="student">Student</option>
            </select>
            <span class="error" id="roleError"></span>
        </div>
    </div>
    <input type="submit" value="Add">
</form>
    </div>
    
</div>


      <!-- Settings Section -->
<div id="settings" class="content-section">
    <!-- View Profile -->
    <div id="viewProfile" class="view-profile-container">
        <img
            class="profile-picture"
            src="../../../assets/images/profile-picture.png"
            alt="profile picture"
        />
        <img
            class="edit-icon" style=" width: 25px; margin:0 auto; display:block; cursor:pointer;"
            src="../../../assets/images/edit-user.png"
            alt="edit profile"
        />
        <p class="profile-name"><?= $_SESSION['name']; ?></p>
        <p class="profile-email"> Gmail: <strong><?= $_SESSION['email']; ?></strong></p>

        <!-- Edit Profile Buttons -->
        <button
            id="editProfileButton"
            class="action-btn"
            onclick="showEditProfile()"
        >
            Edit Profile
        </button>
        <button
            id="changeNameButton"
            class="action-btn"
            onclick="showChangeName()"
        >
            Change Name
        </button>
        <button
            id="resetPasswordButton"
            class="action-btn"
            onclick="showResetPassword()"
        >
            Reset Password
        </button>
    </div>

    <!-- Update Profile -->
    <div
        id="editProfile"
        class="update-profile-container section hidden"
        style="display:none;"
    >
        <h2>Edit Name and Password</h2>
        
    <form id="updateProfileForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="name">New Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    required
                />
                <div class="error" id="nameError"></div>
            </div>
            
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input
                    type="password"
                    id="newPassword"
                    name="newPassword"
                    placeholder="Enter a new password"
                    required
                />
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="error" id="newPasswordError"></div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="confirmPassword"
                    name="confirmPassword"
                    placeholder="Confirm password"
                    required
                />
                <div class="error" id="confirmPasswordError"></div>
            </div>
            
            <div class="form-group">
                <label for="oldPassword">Current Password</label>
                <input
                    type="password"
                    id="oldPassword"
                    name="oldPassword"
                    placeholder="Enter your current password"
                    required
                />
                <div class="error" id="oldPasswordError"></div>
            </div>
            
            <button type="submit" class="btn" id="updateBtn">
                <div class="loading"></div>
                <span class="btn-text">Update Profile</span>
            </button>
        </form>
        <button
            id="backToProfileButton"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>

    <!-- Change Name -->
    <div
        id="changeName"
        class="update-profile-container section hidden"
        style="display:none;"
    >
        <h2>Change Name</h2>
        <form id="changeNameForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="newName">New Name</label>
                <input
                    type="text"
                    id="newName"
                    placeholder="Enter your new full name"
                    required
                />
                <div class="error" id="newNameError"></div>
            </div>
            <div class="form-group">
                <label for="password">Current Password</label>
                <input
                    type="password"
                    id="password"
                    placeholder="Enter your password"
                    required
                />
                <div class="error" id="passwordError"></div>
            </div>
            <button type="submit" class="btn">Update</button>
        </form>
        <button
            id="backToProfileButton2"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>

    <!-- Reset Password -->
    <div
        id="resetPassword"
        class="update-profile-container section hidden"
        style="display:none;"
    >
        <h2>Reset Password</h2>
        <form id="resetPasswordForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input
                    type="password"
                    id="currentPassword"
                    placeholder="Enter your current password"
                    required
                />
                <div class="error" id="currentPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="resetNewPassword">New Password</label>
                <input
                    type="password"
                    id="resetNewPassword"
                    placeholder="Enter your new password"
                    required
                />
                <div class="error" id="newPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="resetConfirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="resetConfirmPassword"
                    placeholder="Confirm your new password"
                    required
                />
                <div class="error" id="resetConfirmPasswordError"></div>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
        <button
            id="backToProfileButton3"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>
</div>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
        <!-- ... (your existing code for add book modal) ... -->
    </div>

   <script src="../../../assets/scripts/dash/super-Admin-Dashboard-Script.js"></script>

 </body>
</html>


    