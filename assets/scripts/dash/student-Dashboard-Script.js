// View Profile
function viewAllBooks() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('allBooks').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   document.getElementById('viewAllBooksButton').classList.add('toggle-btn')
   document.getElementById('viewProfileButton').classList.remove('toggle-btn')
}

function viewProfile() {
   document.getElementById('allBooks').classList.add('hidden')
   document.getElementById('viewProfile').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   document.getElementById('viewProfileButton').classList.add('toggle-btn')
   document.getElementById('viewAllBooksButton').classList.remove('toggle-btn')
}

function editProfile() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('editProfile').classList.remove('hidden')
}

function changeName() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('changeName').classList.remove('hidden')
}

function resetPassword() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('resetPassword').classList.remove('hidden')
}

// Back To Profile Button Functionality
function backToProfile() {
   document.getElementById('viewProfile').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   
   // Clear all error messages
   clearAllErrorMessages()
}

// Function to clear all error messages
function clearAllErrorMessages() {
   // Clear errors from Edit Profile form
   document.getElementById('nameError').innerText = ''
   document.getElementById('oldPasswordError').innerText = ''
   document.getElementById('newPasswordError').innerText = ''
   document.getElementById('confirmPasswordError').innerText = ''
   
   // Clear errors from Change Name form
   document.getElementById('newNameError').innerText = ''
   
   // Clear errors from Reset Password form
   document.getElementById('currentPasswordError').innerText = ''
   document.getElementById('resetConfirmPasswordError').innerText = ''
}

// Update Profile Functionality
document
   .getElementById('updateProfileForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      const nameError = document.getElementById('nameError')
      nameError.innerText = ''
      const oldPasswordError = document.getElementById('oldPasswordError')
      oldPasswordError.innerText = ''
      const newPasswordError = document.getElementById('newPasswordError')
      newPasswordError.innerText = ''
      const confirmPasswordError = document.getElementById('confirmPasswordError')
      confirmPasswordError.innerText = ''

      // Get input values
      let name = document.getElementById('name').value.trim()
      let oldPassword = document.getElementById('oldPassword').value
      let newPassword = document.getElementById('newPassword').value
      let confirmPassword = document.getElementById('confirmPassword').value
      let isValid = true

      // Name validation
      if (name === "") {
         nameError.innerText = '*Name cannot be empty.'
         isValid = false
      } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
         nameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
         isValid = false
      }

      // Old Password validation
      if (oldPassword === "") {
         oldPasswordError.innerText = '*Old password cannot be empty.'
         isValid = false
      }

      // New Password validation
      if (newPassword === "") {
         newPasswordError.innerText = '*New password cannot be empty.'
         isValid = false
      } else if (newPassword.length < 6) {
         newPasswordError.innerText = '*Password must be at least 6 characters long.'
         isValid = false
      } else if (!/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword) || !/[\W_]/.test(newPassword)) {
         newPasswordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
         isValid = false
      }

      // Confirm Password validation
      if (confirmPassword === "") {
         confirmPasswordError.innerText = '*Please confirm your password.'
         isValid = false
      } else if (newPassword !== confirmPassword) {
         confirmPasswordError.innerText = '*Passwords do not match.'
         isValid = false
      }

      // Check if new password is same as old password
      if (oldPassword === newPassword && oldPassword !== "") {
         newPasswordError.innerText = '*New password must be different from old password.'
         isValid = false
      }

      if (isValid) {
         // Update profile name in the view
         document.querySelector('.profile-name').textContent = name

         console.log('Updated Profile:', {
            name,
            oldPassword,
            newPassword,
            confirmPassword,
         })

         // Show success notification
         showNotification('Profile updated successfully!', 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

// Change Name Form Functionality
document
   .getElementById('changeNameForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      const newNameError = document.getElementById('newNameError')
      newNameError.innerText = ''
      // Note: There's no passwordError element in changeName form, so removing that line

      // Get input values
      let newName = document.getElementById('newName').value.trim()
      let password = document.getElementById('password').value
      let isValid = true

      // Name validation
      if (newName === "") {
         newNameError.innerText = '*Name cannot be empty.'
         isValid = false
      } else if (!/^[a-zA-Z\s]{2,}$/.test(newName)) {
         newNameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
         isValid = false
      }

      // Password validation - Note: No error element exists for password in changeName form

      if (password === "") {
         passwordError.innerText = '*Password cannot be empty.'
         isValid = false
      }

      if (isValid) {
         // Update profile name in the view
         document.querySelector('.profile-name').textContent = newName

         console.log('Changed Name:', {
            newName,
            password,
         })

         // Show success notification
         showNotification(`Name changed to "${newName}" successfully!`, 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

// Reset Password Form Functionality
document
   .getElementById('resetPasswordForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      document.getElementById('currentPasswordError').innerText = ''
      // Fixed: using correct ID
      document.getElementById('newPasswordError').innerText = ''
      document.getElementById('resetConfirmPasswordError').innerText = ''

      // Get input values
      let currentPassword = document.getElementById('currentPassword').value
      let resetNewPassword = document.getElementById('resetNewPassword').value
      let resetConfirmPassword = document.getElementById('resetConfirmPassword').value
      let isValid = true

      // Current Password validation
      if (currentPassword === "") {
         document.getElementById('currentPasswordError').innerText = '*Current password cannot be empty.'
         isValid = false
      }

      // New Password validation - Fixed: using correct error element ID
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

      // Confirm Password validation
      if (resetConfirmPassword === "") {
         document.getElementById('resetConfirmPasswordError').innerText = '*Please confirm your password.'
         isValid = false
      } else if (resetNewPassword !== resetConfirmPassword) {
         document.getElementById('resetConfirmPasswordError').innerText = '*Passwords do not match.'
         isValid = false
      }

      // Check if new password is same as current password
      if (currentPassword === resetNewPassword && currentPassword !== "") {
         document.getElementById('newPasswordError').innerText = '*New password must be different from current password.'
         isValid = false
      }

      if (isValid) {
         console.log('Password Reset:', {
            currentPassword,
            resetNewPassword,
            resetConfirmPassword,
         })

         // Show success notification
         showNotification('Password reset successfully!', 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

function logout() {
   if (confirm('Are you sure you want to logout?')) {
      alert('Logged out successfully!')
   }
}

//  settings

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
            alert("Profile updated successfully!");
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


      // JS Live Filtering

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".search-box");
    const categorySelect = document.querySelector(".category-filter");
    const bookCards = document.querySelectorAll(".book-card");

    function filterBooks() {
        const searchText = searchInput.value.toLowerCase();
        const selectedCategory = categorySelect.value;

        bookCards.forEach(card => {
            const title = card.querySelector(".book-title").innerText.toLowerCase();
            const author = card.querySelector(".book-author").innerText.toLowerCase();
            const category = card.querySelector(".book-category").innerText;

            const matchesSearch = title.includes(searchText) || author.includes(searchText);
            const matchesCategory = selectedCategory === "" || category === selectedCategory;

            card.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
        });
    }
    const resetBtn = document.querySelector(".reset-btn");

resetBtn.addEventListener("click", () => {
    searchInput.value = "";         // Clear search box
    categorySelect.value = "";      // Reset select
    bookCards.forEach(card => {
        card.style.display = "block"; // Show all books
    });
});


    searchInput.addEventListener("input", filterBooks);
    categorySelect.addEventListener("change", filterBooks);
});
