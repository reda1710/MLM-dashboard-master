// Function to create and display toast notification
function createToastNotification(id, message, alertType, timer) {
    const toastContainer = document.querySelector('.position-fixed');

    const toastDiv = document.createElement("div");
    toastDiv.className = `toast fade bg-white p-2 shown mt-2`;
    toastDiv.setAttribute("role", "alert");
    toastDiv.setAttribute("aria-live", "assertive");
    toastDiv.setAttribute("aria-atomic", "true");
    toastDiv.setAttribute('data-notification-id', id);

    const toastHeader = document.createElement("div");
    toastHeader.className = `toast-header bg-transparent border-0`;

    const icon = document.createElement("i");

    const toastTitle = document.createElement("span");
                toastTitle.textContent = "Notification";


    switch(alertType) {
        case "success":
            icon.className = "material-icons text-success me-2";
            icon.textContent = "check";
            toastTitle.className = "me-auto text-gradient text-success font-weight-bold";
            break;
        case "info":
            icon.className = "material-icons text-info me-2";
            icon.textContent = "notifications";
            toastTitle.className = "me-auto text-gradient text-info font-weight-bold";
            break;
        case "warning":
            icon.className = "material-icons text-warning me-2";
            icon.textContent = "travel_explore";
            toastTitle.className = "me-auto text-gradient text-warning font-weight-bold";
            break;
        case "danger":
            icon.className = "material-icons text-danger me-2";
            icon.textContent = "campaign";
            toastTitle.className = "me-auto text-gradient text-danger font-weight-bold";
            break;
        default:
            icon.className = "material-icons text-body me-2";
            icon.textContent = "notifications";
            toastTitle.className = "me-auto text-body font-weight-bold";
            break;
    }

    const Ticon = document.createElement("i");
    const toastTime = document.createElement("small");
    Ticon.className = "material-icons text-body me-2";
    Ticon.textContent = "schedule";
    toastTime.className = "text-body";
    toastTime.textContent = timer;

    const closeButton = document.createElement("i");
    closeButton.className = "fas fa-times text-md text-white ms-3 cursor-pointer";
    closeButton.setAttribute("data-bs-dismiss", "toast");
    closeButton.setAttribute("aria-label", "Close");
    closeButton.setAttribute("data-notification-id", id);

    closeButton.addEventListener("click", function () {
        var notificationId = this.getAttribute("data-notification-id");
        markNotificationAsRead(notificationId);
        this.parentNode.remove();
    });

    toastHeader.appendChild(icon);
    toastHeader.appendChild(toastTitle);
    toastHeader.appendChild(Ticon);
    toastHeader.appendChild(toastTime);
    toastHeader.appendChild(closeButton);
    toastDiv.appendChild(toastHeader);

    const horizontalLine = document.createElement("hr");
    horizontalLine.className = "horizontal light m-0";
    toastDiv.appendChild(horizontalLine);

    const toastBody = document.createElement("div");
    toastBody.className = "toast-body";
    toastBody.textContent = message;
    toastDiv.appendChild(toastBody);

    toastContainer.appendChild(toastDiv);

    const toastInstance = new bootstrap.Toast(toastDiv);
    toastInstance.show();
}

// Function to create and append notification HTML
function createNotification(id, message, alertType) {

    // Check if the notificationContainer exists
    var container = document.getElementById("notificationContainer");
    if (!container) return; // If it doesn't exist, do nothing and exit the function

    // Create the main notification div
    var notificationDiv = document.createElement("div");
    notificationDiv.className = "alert alert-" + alertType + " alert-dismissible text-white";
    notificationDiv.setAttribute("role", "alert");

    // Create the message content span
    var messageSpan = document.createElement("span");
    messageSpan.className = "text-sm";
    messageSpan.textContent = message;

    // Create the close button
    var closeButton = document.createElement("button");
    closeButton.type = "button";
    closeButton.className = "btn-close text-lg py-3 opacity-10";
    closeButton.setAttribute("data-bs-dismiss", "alert");
    closeButton.setAttribute("aria-label", "Close");
    closeButton.setAttribute("data-notification-id", id); // Add the id as a data attribute

    // Create the close button icon (times symbol)
    var closeIcon = document.createElement("span");
    closeIcon.setAttribute("aria-hidden", "true");
    closeIcon.innerHTML = "&times;";
    closeButton.appendChild(closeIcon);

    // Add a click event listener to the close button
    closeButton.addEventListener("click", function () {
        var notificationId = this.getAttribute("data-notification-id");
        markNotificationAsRead(notificationId); // Call the function to mark as read
        this.parentNode.remove(); // Remove the notification from the UI
    });

    notificationDiv.appendChild(messageSpan);
    notificationDiv.appendChild(closeButton);

    // Append the notification to the container
    container.appendChild(notificationDiv);
}


function markNotificationAsRead(notificationId) {
    // Send an AJAX request to a PHP script to update the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/update_notification.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Define the data to be sent
    var data = "notification_id=" + encodeURIComponent(notificationId);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle a successful response if needed
                console.log("Notification marked as read.");
            } else {
                // Handle errors if needed
                console.error("Error marking notification as read.");
            }
        }
    };

    xhr.send(data);
}
function timeSince(date) {
    const now = new Date();
    const notificationDate = new Date(date);
    const seconds = Math.floor((now - notificationDate) / 1000);

    let interval = Math.floor(seconds / 31536000); // seconds in a year

    if (interval > 1) {
        return interval + " years ago";
    }
    interval = Math.floor(seconds / 2592000); // seconds in a month
    if (interval > 1) {
        return interval + " months ago";
    }
    interval = Math.floor(seconds / 86400); // seconds in a day
    if (interval > 1) {
        return interval + " days ago";
    }
    interval = Math.floor(seconds / 3600); // seconds in an hour
    if (interval > 1) {
        return interval + " hours ago";
    }
    interval = Math.floor(seconds / 60); // seconds in a minute
    if (interval > 1) {
        return interval + " minutes ago";
    }
    return Math.floor(seconds) + " seconds ago";
}
// Function to fetch unread notifications from the server
function fetchNotifications() {
    fetch('php/notifications.php') // Replace with the correct path to your PHP script
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Check if there are any unread notifications
            if (data.length > 0) {
                //alert Types to send
                // primary,secondary,success,danger,warning,info,light,dark
                // Loop through the notifications and display them
                data.forEach(notification => {
                    timer = timeSince(notification.created_at);
                    createNotification(notification.id, notification.message, notification.alertType)
                    createToastNotification(notification.id, notification.message, notification.alertType, timer);

                });
            }
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });
}

// Call the fetchNotifications function when the page loads
window.addEventListener('load', fetchNotifications);