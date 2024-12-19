
const thumbnails = JSON.parse(document.getElementById('thumbnailsData').textContent) || [];
const thumbnailsPerPage = 5;
let currentPage = 0;

function renderThumbnails() {
    const container = document.getElementById('thumbnailContainer');
    container.innerHTML = '';

    if (thumbnails.length > 0) {
        const start = currentPage * thumbnailsPerPage;
        const end = Math.min(start + thumbnailsPerPage, thumbnails.length);

        for (let i = start; i < end; i++) {
            const img = document.createElement('img');
            img.src = thumbnails[i];
            img.alt = `Thumbnail ${i + 1}`;
            img.className = 'thumbnail';
            img.onclick = () => changeMainImage(thumbnails[i]);
            container.appendChild(img);
        }
    } else {
        container.innerHTML = '<p>No thumbnails available.</p>';
    }

    updatePaginationButtons();
}

function updatePaginationButtons() {
    const prevButton = document.getElementById('prevPage');
    const nextButton = document.getElementById('nextPage');

    prevButton.disabled = currentPage === 0;
    nextButton.disabled = (currentPage + 1) * thumbnailsPerPage >= thumbnails.length;
}

function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}

document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 0) {
        currentPage--;
        renderThumbnails();
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    if ((currentPage + 1) * thumbnailsPerPage < thumbnails.length) {
        currentPage++;
        renderThumbnails();
    }
});

renderThumbnails();
