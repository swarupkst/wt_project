// Navigation tab switching
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(function(sec) {
                sec.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
            document.querySelectorAll('.nav-tab').forEach(function(tab) {
                tab.classList.remove('active');
            });
            document.querySelector('.nav-tab[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
        }

        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Dummy logout function
        function logout() {
            alert('Logging out...');
            // Redirect or perform logout logic here
        }

        // Edit Profile Modal

// edit button functions // Section show/hide
function showEditProfile() {
    document.getElementById('editProfile').style.display = 'block';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}

function showChangeName() {
    document.getElementById('changeName').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}

function showResetPassword() {
    document.getElementById('resetPassword').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}
function backToProfile() {
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'block';
}

// Error clear
function clearAllErrorMessages() {
    // Edit Profile errors
    document.getElementById('nameError').innerText = ''
    document.getElementById('oldPasswordError').innerText = ''
    document.getElementById('newPasswordError').innerText = ''
    document.getElementById('confirmPasswordError').innerText = ''
    // Change Name errors
    document.getElementById('newNameError').innerText = ''
    document.getElementById('passwordError').innerText = ''
    // Reset Password errors
    document.getElementById('currentPasswordError').innerText = ''
    document.getElementById('resetConfirmPasswordError').innerText = ''
}

// Show notification (simple implementation)
function showNotification(message, type) {
    // You can replace with a more sophisticated notification system
    alert(message)
}

// Update Profile Form

// settings

// edit profile
         document.getElementById("updateProfileForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const oldPassword = document.getElementById("oldPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    const formData = new FormData();
    formData.append("name", name);
    formData.append("oldPassword", oldPassword);
    formData.append("newPassword", newPassword);
    formData.append("confirmPassword", confirmPassword);

    fetch("../../../Controllers/settings/update-profile.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // alert("Profile updated successfully!");
        } else {
            alert(data.message || "Update failed!");
        }
    });
});

// change name
document.getElementById("changeNameForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const newName = document.getElementById("newName").value;
    const password = document.getElementById("password").value;

    const formData = new FormData();
    formData.append("newName", newName);
    formData.append("password", password);

    fetch("../../../Controllers/settings/change-name.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
});

// reset password
document.getElementById("resetPasswordForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const currentPassword = document.getElementById("currentPassword").value;
    const resetNewPassword = document.getElementById("resetNewPassword").value;
    const resetConfirmPassword = document.getElementById("resetConfirmPassword").value;

    const formData = new FormData();
    formData.append("currentPassword", currentPassword);
    formData.append("resetNewPassword", resetNewPassword);
    formData.append("resetConfirmPassword", resetConfirmPassword);

    fetch("../../../Controllers/settings/reset-password.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
});


// validations
document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let name = document.getElementById('name').value.trim()
    let oldPassword = document.getElementById('oldPassword').value
    let newPassword = document.getElementById('newPassword').value
    let confirmPassword = document.getElementById('confirmPassword').value
    let isValid = true

    // Name validation
    if (name === "") {
        document.getElementById('nameError').innerText = '*Name cannot be empty.'
        isValid = false
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        document.getElementById('nameError').innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
        isValid = false
    }
    // Old Password
    if (oldPassword === "") {
        document.getElementById('oldPasswordError').innerText = '*Old password cannot be empty.'
        isValid = false
    }
    // New Password
    if (newPassword === "") {
        document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
        isValid = false
    } else if (newPassword.length < 6) {
        document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
        isValid = false
    } else if (!/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword) || !/[\W_]/.test(newPassword)) {
        document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
        isValid = false
    }
    // Confirm Password
    if (confirmPassword === "") {
        document.getElementById('confirmPasswordError').innerText = '*Please confirm your password.'
        isValid = false
    } else if (newPassword !== confirmPassword) {
        document.getElementById('confirmPasswordError').innerText = '*Passwords do not match.'
        isValid = false
    }
    // New password != Old password
    if (oldPassword === newPassword && oldPassword !== "") {
        document.getElementById('newPasswordError').innerText = '*New password must be different from old password.'
        isValid = false
    }
    if (isValid) {
        document.querySelector('.profile-name').textContent = name
        showNotification('Profile updated successfully!', 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})

// Change Name Form
document.getElementById('changeNameForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let newName = document.getElementById('newName').value.trim()
    let password = document.getElementById('password').value
    let isValid = true

    // Name validation
    if (newName === "") {
        document.getElementById('newNameError').innerText = '*Name cannot be empty.'
        isValid = false
    } else if (!/^[a-zA-Z\s]{2,}$/.test(newName)) {
        document.getElementById('newNameError').innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
        isValid = false
    }
    // Password validation
    if (password === "") {
        document.getElementById('passwordError').innerText = '*Password cannot be empty.'
        isValid = false
    }
    if (isValid) {
        document.querySelector('.profile-name').textContent = newName
        showNotification(`Name changed to "${newName}" successfully!`, 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})

// Reset Password Form
document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let currentPassword = document.getElementById('currentPassword').value
    let resetNewPassword = document.getElementById('resetNewPassword').value
    let resetConfirmPassword = document.getElementById('resetConfirmPassword').value
    let isValid = true

    // Current Password
    if (currentPassword === "") {
        document.getElementById('currentPasswordError').innerText = '*Current password cannot be empty.'
        isValid = false
    }
    // New Password
    if (resetNewPassword === "") {
        document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
        isValid = false
    } else if (resetNewPassword.length < 6) {
        document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
        isValid = false
    } else if (!/[A-Z]/.test(resetNewPassword) || !/[a-z]/.test(resetNewPassword) || !/[0-9]/.test(resetNewPassword) || !/[\W_]/.test(resetNewPassword)) {
        document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
        isValid = false
    }
    // Confirm Password
    if (resetConfirmPassword === "") {
        document.getElementById('resetConfirmPasswordError').innerText = '*Please confirm your password.'
        isValid = false
    } else if (resetNewPassword !== resetConfirmPassword) {
        document.getElementById('resetConfirmPasswordError').innerText = '*Passwords do not match.'
        isValid = false
    }
    // New password != Current password
    if (currentPassword === resetNewPassword && currentPassword !== "") {
        document.getElementById('newPasswordError').innerText = '*New password must be different from current password.'
        isValid = false
    }
    if (isValid) {
        showNotification('Password reset successfully!', 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})


// after

// Show user list and hide the add-user form
function showManageUsers() {
    document.getElementById('userSection').style.display = 'block';
    document.getElementById('addUserSection').style.display = 'none';
}

// Show add-user form and hide the user list
function showRegisterForm() {
    document.getElementById('userSection').style.display = 'none';
    document.getElementById('addUserSection').style.display = 'block';
}


        function editUser(id, name, email, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_password').value = '';
            document.getElementById('editModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function deleteUser(id, name) {
            if (confirm(' Are you sure you want to delete this user?\n\nName: ' + name + '\n\nIf you click "Ok" then this action cannot be do!')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.innerHTML = '<input type="hidden" name="delete_id" value="' + id + '">';
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase();
            const table = document.querySelector('table tbody');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells.length > 1) {
                    const name = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const role = row.cells[3].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm) || searchTerm === '') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        }
        
        // Real-time search as user types
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', searchTable);
        });
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
            }
        });
        
        // Form validation

        // Edit Form Validation with inline error messages
    document.getElementById('editForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Get input values
        const name = document.getElementById('edit_name').value.trim();
        const email = document.getElementById('edit_email').value.trim();
        const password = document.getElementById('edit_password').value;
        const role = document.getElementById('edit_role').value;

        // Get error spans
        const nameError = document.getElementById('editNameError');
        const emailError = document.getElementById('editEmailError');
        const passwordError = document.getElementById('editPasswordError');
        const roleError = document.getElementById('editRoleError');

        // Clear previous errors
        nameError.innerText = '';
        emailError.innerText = '';
        passwordError.innerText = '';
        roleError.innerText = '';

        // Name validation
    if (name === "") {
        nameError.innerText = '*Name cannot be empty.';
        isValid = false;
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        nameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).';
        isValid = false;
    }

    // Email validation
    if (email === "") {
        emailError.innerText = '*Email cannot be empty.';
        isValid = false;
    } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
        emailError.innerText = '*Please enter a valid email address.';
        isValid = false;
    }

    // Password validation (optional if left blank)
    if (password !== "") {
        if (password.length < 6) {
            passwordError.innerText = '*Password must be at least 6 characters long.';
            isValid = false;
        } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
            passwordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.';
            isValid = false;
        }
    }

    // Role validation
    if (role === "") {
        roleError.innerText = '*Please select a role.';
        isValid = false;
    }

    // Only prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
    }
});

    console.log('User Management System Loaded Successfully!');

// Add user form
document.getElementById('userForm').addEventListener('submit', function(e) {
    let isValid = true;

    // Get values
    const name = document.getElementsByName('name')[0].value.trim();
    const email = document.getElementsByName('email')[0].value.trim();
    const password = document.getElementsByName('password')[0].value;
    const role = document.getElementsByName('role')[0].value;

    // Get error spans
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const roleError = document.getElementById('roleError');

    // Clear old errors
    nameError.innerText = '';
    emailError.innerText = '';
    passwordError.innerText = '';
    roleError.innerText = '';

    // Name validation
    if (name === "") {
        nameError.innerText = '*Name cannot be empty.';
        isValid = false;
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        nameError.innerText = '*Please enter a valid name (at least 2 letters, only letters & spaces).';
        isValid = false;
    }

    // Email validation
    if (email === "") {
        emailError.innerText = '*Email cannot be empty.';
        isValid = false;
    } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
        emailError.innerText = '*Please enter a valid email address.';
        isValid = false;
    }

    // Password validation
    if (password === "") {
        passwordError.innerText = '*Password cannot be empty.';
        isValid = false;
    } else if (password.length < 6) {
        passwordError.innerText = '*Password must be at least 6 characters long.';
        isValid = false;
    } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
        passwordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.';
        isValid = false;
    }

    // Role validation
    if (role === "") {
        roleError.innerText = '*Please select a role.';
        isValid = false;
    }

    // Stop form submission if invalid
    if (!isValid) {
        e.preventDefault();
    }
});

console.log('Add Users Successfully!');
    

// <!-- Dropdown bar -->

// Function to filter table by role
function filterByRole() {
    const selectedRole = document.getElementById('roleFilter').value;
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    
    tableRows.forEach(row => {
        const rowRole = row.getAttribute('data-role');
        
        if (selectedRole === 'all' || rowRole === selectedRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update table display message if no rows are visible
    updateTableMessage();
}

// Function to reset all filters
function resetFilters() {
    document.getElementById('roleFilter').value = 'all';
    document.getElementById('searchInput').value = '';
    
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    tableRows.forEach(row => {
        row.style.display = '';
    });
    
    updateTableMessage();
}

// Function to update table message when no results found
function updateTableMessage() {
    const visibleRows = document.querySelectorAll('#tableBody .user-row:not([style*="display: none"])');
    const messageRow = document.querySelector('#tableBody .no-results-message');
    
    if (visibleRows.length === 0) {
        if (!messageRow) {
            const tbody = document.getElementById('tableBody');
            const newRow = document.createElement('tr');
            newRow.className = 'no-results-message';
            newRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 30px; color: #666;">No users found matching the selected criteria</td>';
            tbody.appendChild(newRow);
        }
    } else {
        if (messageRow) {
            messageRow.remove();
        }
    }
}

// Enhanced search function that works with role filter
function searchTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const selectedRole = document.getElementById('roleFilter').value;
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    
    tableRows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        const role = row.getAttribute('data-role');
        const roleText = row.cells[3].textContent.toLowerCase();
        
        const matchesSearch = name.includes(searchInput) || 
                            email.includes(searchInput) || 
                            roleText.includes(searchInput);
        
        const matchesRole = selectedRole === 'all' || role === selectedRole;
        
        if (matchesSearch && matchesRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateTableMessage();
}


// manage books 
 

// ===================== SEARCH =====================
function searchBooks() {
    const input = document.getElementById("searchBookInput").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        // Skip the "No books found" row
        if (row.cells.length < 6) return;
        
        const title = row.cells[1].innerText.toLowerCase();
        const author = row.cells[2].innerText.toLowerCase();
        const category = row.cells[3].innerText.toLowerCase();
        
        if (title.includes(input) || author.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// ===================== FILTER =====================
function filterByCategory() {
    const filterValue = document.getElementById("categoryFilter").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        // Skip the "No books found" row
        if (!row.dataset.category) return;
        
        const category = row.dataset.category.toLowerCase();
        if (filterValue === "all" || category === filterValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function resetBookFilters() {
    document.getElementById("searchBookInput").value = "";
    document.getElementById("categoryFilter").value = "all";
    
    // Show all rows
    const rows = document.querySelectorAll("#booksTable tbody tr");
    rows.forEach(row => {
        row.style.display = "";
    });
}

// ===================== ADD / BACK =====================
function showAddBookForm() {
    document.getElementById("bookSection").style.display = "none";
    document.getElementById("addBookSection").style.display = "block";
}

function showManageBooks() {
    document.getElementById("bookSection").style.display = "block";
    document.getElementById("addBookSection").style.display = "none";
}

// ===================== EDIT MODAL =====================
function editBook(id, title, author, category, copies) {
    document.getElementById("edit_book_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_author").value = author;
    document.getElementById("edit_category").value = category;
    document.getElementById("edit_copies").value = copies;
    document.getElementById("editBookModal").style.display = "block";
}

function closeEditBookModal() {
    document.getElementById("editBookModal").style.display = "none";
}

// ===================== DELETE CONFIRM =====================
function deleteBook(id, title) {
    if (confirm("Are you sure you want to delete the book: " + title + "?")) {
        // Use the same page with GET parameter
        window.location.href = "librarian-Dashboard.php?delete_id=" + id;
    }
}

// ===================== MODAL CLOSE CLICK OUTSIDE =====================
window.onclick = function(event) {
    const modal = document.getElementById("editBookModal");
    if (event.target === modal) {
        closeEditBookModal();
    }
}

// ===================== FORM VALIDATION =====================
document.getElementById("bookForm").addEventListener("submit", function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const author = document.querySelector('input[name="author"]').value.trim();
    const category = document.querySelector('input[name="category"]').value.trim();
    const copies = parseInt(document.querySelector('input[name="copies"]').value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    }
});

document.getElementById("editBookForm").addEventListener("submit", function(e) {
    const title = document.getElementById("edit_title").value.trim();
    const author = document.getElementById("edit_author").value.trim();
    const category = document.getElementById("edit_category").value.trim();
    const copies = parseInt(document.getElementById("edit_copies").value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    }
});


// ===================== SEARCH =====================
function searchBooks() {
    const input = document.getElementById("searchBookInput").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        if (row.cells.length < 6) return;
        
        const title = row.cells[1].innerText.toLowerCase();
        const author = row.cells[2].innerText.toLowerCase();
        const category = row.cells[3].innerText.toLowerCase();
        
        if (title.includes(input) || author.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// ===================== FILTER =====================
function filterByCategory() {
    const filterValue = document.getElementById("categoryFilter").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        if (!row.dataset.category) return;
        
        const category = row.dataset.category.toLowerCase();
        if (filterValue === "all" || category === filterValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function resetBookFilters() {
    document.getElementById("searchBookInput").value = "";
    document.getElementById("categoryFilter").value = "all";
    
    const rows = document.querySelectorAll("#booksTable tbody tr");
    rows.forEach(row => {
        row.style.display = "";
    });
}

// ===================== ADD / BACK =====================
function showAddBookForm() {
    document.getElementById("bookSection").style.display = "none";
    document.getElementById("addBookSection").style.display = "block";
}

function showManageBooks() {
    document.getElementById("bookSection").style.display = "block";
    document.getElementById("addBookSection").style.display = "none";
}

// ===================== EDIT MODAL =====================
function editBook(id, title, author, category, copies) {
    document.getElementById("edit_book_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_author").value = author;
    document.getElementById("edit_category").value = category;
    document.getElementById("edit_copies").value = copies;
    document.getElementById("editBookModal").style.display = "block";
}

function closeEditBookModal() {
    document.getElementById("editBookModal").style.display = "none";
}

// ===================== DELETE CONFIRM =====================
function deleteBook(id, title) {
    if (confirm("Are you sure you want to delete the book: " + title + "?")) {
        window.location.href = "librarian-Dashboard.php?delete_id=" + id;
    }
}

// ===================== MODAL CLOSE CLICK OUTSIDE =====================
window.onclick = function(event) {
    const modal = document.getElementById("editBookModal");
    if (event.target === modal) {
        closeEditBookModal();
    }
}

// ===================== FORM VALIDATION + ALERT =====================

// Add Book form
document.getElementById("bookForm").addEventListener("submit", function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const author = document.querySelector('input[name="author"]').value.trim();
    const category = document.querySelector('input[name="category"]').value.trim();
    const copies = parseInt(document.querySelector('input[name="copies"]').value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    } else {
        alert("Book will be added successfully!");
    }
});

// Edit Book form
document.getElementById("editBookForm").addEventListener("submit", function(e) {
    const title = document.getElementById("edit_title").value.trim();
    const author = document.getElementById("edit_author").value.trim();
    const category = document.getElementById("edit_category").value.trim();
    const copies = parseInt(document.getElementById("edit_copies").value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    } else {
        alert("Book will be updated successfully!");
    }
});

