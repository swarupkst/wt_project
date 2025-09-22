<?php
session_start();
include '../../../Models/student/book-View.php';
if (!isset($_SESSION['email'])) {
    header("Location: ../../auth/login-Register-Page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Student Dashboard - Library System</title>
      <link rel="stylesheet" href="../../../assets/styles/dash/student-Dashboard-Style.css" />

   </head>
      <body>
      <div class="container">
         <!-- Header -->
         <div class="header">
            <div class="logo">
               <h2>📚 Library System</h2>
               <p>Student Dashboard</p>
            </div>
            <div class="user-info">
               <div class="student-avatar" 
            style=" width: 45px;
            height: 45px;
            background: #3D74B6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;" 
            >S</div> 
               <div>
                  <strong>Welcome, <span style="color:#1B56FD"><?= $_SESSION['name']; ?></span>!</strong><br/>
                  <small><?= $_SESSION['email']; ?></small>
               </div>
               <img src="setting.png" alt="" style=" width: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;" 
            onclick="viewProfile()">
               <button class="logout-btn" onclick="window.location.href='../../../Controllers/auth/logout.php'">Logout</button>
            </div>
         </div>

         <!-- Stats -->
         <!-- <div class="stats">
            <div class="stat-card">
               <div class="stat-number">1000</div>
               <div class="stat-label">Total Books</div>
            </div>
            <div class="stat-card">
               <div class="stat-number">3</div>
               <div class="stat-label">My Books</div>
            </div>
            <div class="stat-card">
               <div class="stat-number">1</div>
               <div class="stat-label">Due Soon</div>
            </div>
         </div> -->

         <!-- Main Content -->
               <!-- All Books -->
               <div id="allBooks" class="section">
                  <!-- Search and Filter Section -->
         <h3 class="section-title">All Books</h3>
    <!-- Search Form -->
    <form method="GET" action="" class="search-form">
        <input type="text" 
               name="search" 
               class="search-box"
               placeholder="Search by title or author..." 
               value="<?php echo htmlspecialchars($search); ?>">

        <button type="submit" class="search-btn">Search</button>

        <select name="category" class="category-filter">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                        <?php echo ($category == $cat['category']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['category']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- Reset Button -->
    <button type="button" class="reset-btn">Reset</button>
    </form>
                
            <div class="section2">
            <!-- Books Display -->
            <div class="books-grid">
                <?php if (count($books) > 0): ?>
                    <?php foreach($books as $book): ?>
                        <div class="book-card">
                            <h4 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h4>
                            <div class="book-author">by <?php echo htmlspecialchars($book['author']); ?></div>
                            <div class="book-category"><?php echo htmlspecialchars($book['category']); ?></div>
                            <div class="book-copies"><?php echo $book['copies']; ?> copies available</div>
                            <div class="book-date">Added: <?php echo date('M d, Y', strtotime($book['created_at'])); ?></div>
                            
                            <?php if ($book['copies'] > 0): ?>
                                <button class="request-btn" onclick="requestBook(<?php echo $book['id']; ?>)">
                                    Request Book
                                </button>
                            <?php else: ?>
                                <button class="request-btn" disabled>
                                    Out of Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-books">
                        <h3>📚 No books found</h3>
                        <p>Try adjusting your search terms</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>


               </div>

               <!-- View Profile -->
               <div id="viewProfile" class="view-profile-container hidden">
                  <!-- <img
                     class="profile-picture"
                     src="../../../assets/images/profile-picture.png"
                     alt="profile picture"
                  />
                  <img
                     class="edit-icon" style=" width: 25px; margin:0 auto; display:block; cursor:pointer;"
                     src="../../../assets/images/edit-user.png"
                     alt="edit profile"
                  /> -->

<!-- Profile Picture Display & Upload -->
<img
  class="profile-picture"
  id="profile-picture"
  src="<?= htmlspecialchars($profile_img_path) ?>"
  alt=""
  style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #1B56FD;"
/>
<label for="profile-picture-input">
  <img
    class="edit-icon"
    style="width: 25px; margin:0 auto; display:block; cursor:pointer;"
    src="../../../assets/images/edit-user.png"
    alt="edit profile"
  />
</label>
<input
  type="file"
  id="profile-picture-input"
  accept="image/*"
  style="display: none;"
  onchange="uploadProfilePicture(event)"
/>


                  <p class="profile-name"><?= $_SESSION['name']; ?></p>
                  <p class="profile-email"> Gmail: <strong><?= $_SESSION['email']; ?></strong></p>

         <!-- Edit Profile Buttons -->
                  <button
                     id="editProfileButton"
                     class="action-btn2"
                     onclick="editProfile()"
                  >
                     Edit Profile
                  </button>
                  
                  <button
                     id="changeNameButton"
                     class="action-btn2"
                     onclick="changeName()"
                  >
                     Change Name
                  </button>
                  <button
                     id="resetPasswordButton"
                     class="action-btn2"
                     onclick="resetPassword()"
                  >
                     Reset Password
                  </button>
                  <button
                     class="logout-btn back-button"
                     onclick="viewAllBooks()"
                  >
                     Back
                  </button>
               </div>
               
               <!-- Update Profile -->
               <div
                  id="editProfile"
                  class="update-profile-container section hidden"
               >
               <!-- edit profile block -->
                  <h2>Edit Name and Password</h2>
            <form id="updateProfileForm">
                     <div class="form-group">
                        <label for="name">Name</label>
                        <input
                           type="text"
                           id="name"
                           placeholder="Enter your name"
                        />
                     </div>
                     <div class="error" id="nameError"></div>
                     <div class="form-group">
                        <label for="oldPassword">Old Password</label>
                        <input
                           type="password"
                           id="oldPassword"
                           placeholder="Enter your old password"
                        />
                     </div>
                     <div class="error" id="oldPasswordError"></div>
                     <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input
                           type="password"
                           id="newPassword"
                           placeholder="Enter a new password"
                           
                        />
                     </div>
                     <div class="error" id="newPasswordError"></div>
                     <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input
                           type="password"
                           id="confirmPassword"
                           placeholder="Confirm password"
                           
                        />
                     </div>
                     <div class="error" id="confirmPasswordError"></div>
                     <button type="submit" class="btn">Update</button>
                  </form>

                  <!-- Back Button -->
                  <button
                     id="backToProfileButton"
                     class="logout-btn back-button"
                     onclick="backToProfile()"
                  >
                     Back
                  </button>
               </div>
            
            <!-- change name -->
               <div
                  id="changeName"
                  class="update-profile-container section hidden"
               >
               <!-- edit profile block -->
                  <h2>Change Name</h2>
                  <form id="changeNameForm">
                     <div class="form-group">
                        <label for="newName">New Name</label>
                        <input
                           type="text"
                           id="newName"
                           placeholder="Enter your new full name"
                           
                        />
                     </div>
                     <div class="error" id="newNameError"></div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input
                           type="password"
                           id="password"
                           placeholder="Enter your password"
                          
                        />
                     </div>
                     <div class="error" id="passwordError"></div>
                     <button type="submit" class="btn">Update</button>
                  </form>

                  <!-- Back Button -->
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
               >
               <!-- reset password block -->
                  <h2>Reset Password</h2>
                  <form id="resetPasswordForm">
                     <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input
                           type="password"
                           id="currentPassword"
                           placeholder="Enter your current password"
                          
                        />
                     </div>
                     <div class="error" id="currentPasswordError"></div>
                     <div class="form-group">
                        <label for="resetNewPassword">New Password</label>
                        <input
                           type="password"
                           id="resetNewPassword"
                           placeholder="Enter your new password"
                           
                        />
                     </div>
                     <div class="error" id="newPasswordError"></div>
                     <div class="form-group">
                        <label for="resetConfirmPassword">Confirm Password</label>
                        <input
                           type="password"
                           id="resetConfirmPassword"
                           placeholder="Confirm your new password"
                           
                        />
                        <div class="error" id="resetConfirmPasswordError"></div>
                     </div>
                     <button type="submit" class="btn">Reset Password</button>
                  </form>

                  <!-- Back Button -->
                  <button
                     id="backToProfileButton3"
                     class="logout-btn back-button"
                     onclick="backToProfile()"
                  >
                     Back
                  </button>
               </div>
            </div>
            
            <!-- Right: My Info -->
            <div class="my-info" style="display:none">
               <!-- Quick Actions -->
               <div class="section">
                  <h3 class="section-title">Quick Actions</h3>
                  <div class="quick-actions">
                     <button
                        id="viewAllBooksButton"
                        class="action-btn"
                        onclick="viewAllBooks()"
                     >
                        All Books
                     </button>
                     <!-- <button class="action-btn" onclick="viewMyBooks()">
                        📚 View My Books
                     </button> -->
                     <button
                        id="viewProfileButton"
                        class="action-btn"
                        onclick="viewProfile()"
                     >
                        My Profile
                     </button>
                  </div>
               </div>
               </div> 

                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="../../../assets/scripts/dash/student-Dashboard-Script.js"></script>
      
      <!-- view books -->
       <script>
        function requestBook(bookId) {
            alert("Requesting book ID: " + bookId + " Done!");
            // Here you would typically make an AJAX request to the server to process the book request.
        }
    </script>

    <script>
function uploadProfilePicture(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    if (!file) return;

    // Instant preview (optional, not persistent until page reload)
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profile-picture').src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Prepare form data
    const formData = new FormData();
    formData.append('profile_picture', file);

    // Send the file to server 
    fetch('../../../Controllers/upload-profile-picture.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // For persistent preview after upload, update src
            document.getElementById('profile-picture').src = "../../../" + data.path;
            alert("Profile picture updated!");
        } else {
            alert("Upload failed! " + (data.error || ""));
        }
    });
}
    </script>

   </body>
</html>
