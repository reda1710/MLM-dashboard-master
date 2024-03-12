document.addEventListener("DOMContentLoaded", function () {
    // Add an event listener to the logout link
    const logoutLink = document.querySelector("#logoutLink");

    if (logoutLink) {
        logoutLink.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default click behavior (following the href)

            // Make an AJAX request to logout.php
            fetch("php/logout.php")
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Redirect to the login page after successful logout
                        window.location.href = "sign-in.html"; // Adjust the URL as needed
                    } else {
                        // Handle logout failure (if needed)
                        alert("Logout failed. Please try again.");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    }
});
