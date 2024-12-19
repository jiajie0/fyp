document.getElementById('viewMoreBtn').addEventListener('click', function() {
    var descriptionText = document.getElementById('gameDescription');
    var viewMoreButton = document.getElementById('viewMoreBtn');

    // Toggle between adding/removing the 'expanded' class
    if (descriptionText.classList.contains('expanded')) {
        descriptionText.classList.remove('expanded'); // Collapse text
        viewMoreButton.textContent = 'View More'; // Change button text
    } else {
        descriptionText.classList.add('expanded'); // Expand text
        viewMoreButton.textContent = 'View Less'; // Change button text
    }
});
