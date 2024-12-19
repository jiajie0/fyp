const levels = [1, 2, 3, 4, 5];
const ratingMark1 = JSON.parse(document.getElementById('ratingMark1Data').textContent);
const ratingMark0 = JSON.parse(document.getElementById('ratingMark0Data').textContent);

const ctx = document.getElementById('ratingChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: levels.map(level => `Player Lv ${level}`),
        datasets: [
            {
                label: 'Recommend',
                data: ratingMark1,
                backgroundColor: '#007bff',
                borderWidth: 0,
            },
            {
                label: 'Do Not Recommend',
                data: ratingMark0,
                backgroundColor: '#dc3545',
                borderWidth: 0,
            }
        ],
    },
    options: {
        responsive: true,
        scales: {
            x: {
                grid: { display: false },
            },
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, display: false },
                grid: { display: false },
            },
        },
    },
});
