
    function saveProfile() {
    const profileFields = ['firstname', 'lastname', 'email', 'Position'];
    const updatedData = {};

    profileFields.forEach(field => {
    const label = document.getElementById(field + 'Label');
    const input = document.getElementById(field + 'Input');
    if (label && input) {
    label.textContent = input.value;
    updatedData[field] = input.value;
}
});

    // You can send updatedData and selectedCountry to the server for saving the changes.
    // Example: Make AJAX requests to update the user's profile data and selected country.

    // Save profile data
    fetch('php/update_profile.php', {
    method: 'POST',
    body: JSON.stringify(updatedData),
    headers: {
    'Content-Type': 'application/json'
}
})
    .then(response => response.json())
    .then(profileData => {
    if (profileData.success) {
    alert("Profile updated successfully.");
} else {
    alert("Error updating profile: " + profileData.error);
}
})
    .catch(error => {
    console.error("Error:", error);
});

    toggleEditProfile();
}

    // Call the saveProfile function when needed
    // saveProfile();

    // Function to toggle edit mode for profile fields
    function toggleEditProfile() {
    const profileFields = ['firstname', 'lastname', 'email', 'Position'];
    const isEditMode = isProfileInEditMode();

    profileFields.forEach(field => {
    const label = document.getElementById(field + 'Label');
    const input = document.getElementById(field + 'Input');
    if (label && input) {
    if (isEditMode) {
    // If in edit mode, display the label with the current input value
    label.textContent = input.value;
} else {
    // If not in edit mode, display the input with the current label value
    input.value = label.textContent;
}
    label.style.display = isEditMode ? 'inline' : 'none';
    input.style.display = isEditMode ? 'none' : 'block';
}
});

    // Toggle the "Save Profile" button
    const saveProfileButton = document.getElementById('saveProfileButton');
    if (saveProfileButton) {
    saveProfileButton.style.display = isEditMode ? 'none' : 'block';
}
}

    // Function to check if profile fields are in edit mode
    function isProfileInEditMode() {
    const firstnameInput = document.getElementById('firstnameInput');
    return firstnameInput && firstnameInput.style.display === 'block';
}

    // Function to fetch user data
    function fetchData() {
    fetch('php/get_user_data.php') // Replace with the actual PHP endpoint
        .then(response => response.json())
        .then(data => {
            if (data.user_id) {
                populateUserInfo(data);
            } else {
                console.error("Error fetching user data");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
}

    // Function to populate user information
    function populateUserInfo(userData) {
    const capitalizedFirstName = userData.firstname.charAt(0).toUpperCase() + userData.firstname.slice(1);
    const capitalizedLastName = userData.lastname.charAt(0).toUpperCase() + userData.lastname.slice(1);

// Combine the capitalized first and last names with a space in between
// Set the content of the "nameLabel" element
    document.getElementById("nameLabel").textContent = capitalizedFirstName + " " + capitalizedLastName;
    document.getElementById("firstnameLabel").textContent = userData.firstname;
    document.getElementById("lastnameLabel").textContent = userData.lastname;
    document.getElementById("emailLabel").textContent = userData.email;
    document.getElementById("PositionLabel").textContent = userData.Position;

}

    // Add click event listeners to the Edit Profile button
    const editProfileButton = document.getElementById('editProfileButton');
    if (editProfileButton) {
    editProfileButton.addEventListener('click', toggleEditProfile);
}

    // Populate user information and the country dropdown when the page loads
    window.addEventListener('DOMContentLoaded', fetchData);