// Function to fetch data from PHP script and update HTML elements
function fetchData() {
    fetch('php/fetch_data.php')
        .then(response => response.json())
        .then(data => {
            const user_id = data.user_id;
            const signIn_Element = document.getElementById('signIn_Element');
            const signIn_Element0 = document.getElementById('signIn_Element0');
            const signIn_Element1 = document.getElementById('signIn_Element1');
            const signIn_Element2 = document.getElementById('signIn_Element2');
            const signIn_Element3 = document.getElementById('signIn_Element3');
            const logout_Element = document.getElementById('logout_Element');

            if (user_id > 0) {
                signIn_Element0.style.display = 'none';
                signIn_Element1.style.display = 'block';
                signIn_Element2.style.display = 'none';
                signIn_Element3.style.display = 'none';
                logout_Element.style.display = 'block';
            } else {
                signIn_Element.style.display = 'none';
                signIn_Element0.style.display = 'block';
                signIn_Element1.style.display = 'none';
                signIn_Element2.style.display = 'block';
                signIn_Element3.style.display = 'block';
                logout_Element.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
}

// Call the function to fetch and update data when the page loads
fetchData();
