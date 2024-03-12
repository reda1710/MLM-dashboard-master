// Function to handle button clicks
function handleButtonClick(button) {
    const buttonId = button.id;

    switch (buttonId) {
        case "sidebarTypeDark":
        case "sidebarTypeTransparent":
        case "sidebarTypeWhite":
            sidebarTypeClick(button);
            break;
        case "navbarFixed":
            navbarClick(button);
            break;
        case "sidebarColorPrimary":
        case "SidebarColorDark":
        case "SidebarColorInfo":
        case "SidebarColorSuccess":
        case "SidebarColorWarning":
        case "SidebarColorDanger":
            sidebarColorClick(button);
            break;
    }
}

// Function to toggle dark mode
function toggleDarkMode() {
    const body = document.body;
    const darkModeToggle = document.getElementById('dark-version');
    const savedDarkMode = localStorage.getItem('darkMode') || 'false';

    body.classList.toggle('dark-version', savedDarkMode === 'true');
    darkModeToggle.checked = savedDarkMode === 'true';

    darkModeToggle.addEventListener('change', function () {
        const darkModeEnabled = darkModeToggle.checked;
        localStorage.setItem('darkMode', darkModeEnabled.toString());
        body.classList.toggle('dark-version', darkModeEnabled);
    });
}

// Function to handle sidebar type button click
function sidebarTypeClick(button) {
    const colorName = button.id.replace('sidebarType', '');
    localStorage.setItem("NavType", colorName);
    sidebarType(button);
}

// Function to handle navbar checkbox click
function navbarClick(checkbox) {
    const isChecked = checkbox.checked;
    localStorage.setItem('navbarFixed', isChecked);
    navbarFixed(checkbox);
}

// Function to apply saved navbar state
function applySavedNavbar() {
    const savedNavbarFixedState = localStorage.getItem('navbarFixed');
    const button = document.getElementById('navbarFixed');

    if (savedNavbarFixedState === 'true') {
        button.checked = true;
        navbarClick(button);
    }
}

// Function to handle sidebar color button click
function sidebarColorClick(button) {
    const colorName = button.id;
    localStorage.setItem("NavColor", colorName);
    sidebarColor(button);
}

// Function to retrieve and apply the saved sidebar type
function applySavedType() {
    const savedNavColor = localStorage.getItem("NavType");
    if (savedNavColor) {
        const buttonId = `sidebarType${savedNavColor}`;
        const button = document.getElementById(buttonId);
        sidebarTypeClick(button);
    }
}

// Function to retrieve and apply the saved sidebar color
function applySavedColor() {
    const savedNavColor = localStorage.getItem("NavColor");
    if (savedNavColor) {
        const button = document.getElementById(savedNavColor);
        sidebarColorClick(button);
    }
}

// Function to load and apply settings
function loadSettings() {
    toggleDarkMode();
    applySavedType();
    applySavedColor();
    applySavedNavbar();
}

// Load and apply settings on page load
window.addEventListener('load', loadSettings);