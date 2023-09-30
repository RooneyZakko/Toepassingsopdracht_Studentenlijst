document.addEventListener('DOMContentLoaded', function () {
    // Functie om de studentdetails te tonen of te verbergen
    function toggleDetails(event) {
        const card = event.currentTarget;
        const details = card.querySelector('.student-details');

        if (details.style.display === 'none' || details.style.display === '') {
            details.style.display = 'block';
        } else {
            details.style.display = 'none';
        }
    }

    const studentCards = document.querySelectorAll('.student-card');
    studentCards.forEach(card => {
        card.addEventListener('click', toggleDetails);
    });

    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    searchInput.addEventListener('input', searchStudents);
    sortSelect.addEventListener('change', sortStudents);

    // Functie om studenten te zoeken op basis van de zoekterm
    function searchStudents() {
        const searchTerm = searchInput.value.toLowerCase();
        studentCards.forEach(card => {
            const studentName = card.querySelector('h2').textContent.toLowerCase();
            if (studentName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Functie om studenten te sorteren op naam
    function sortStudents() {
        const sortBy = sortSelect.value;
        const sortedCards = Array.from(studentCards);

        sortedCards.sort((a, b) => {
            const nameA = a.querySelector('h2').textContent.toLowerCase();
            const nameB = b.querySelector('h2').textContent.toLowerCase();

            if (sortBy === 'name-asc') {
                return nameA.localeCompare(nameB);
            } else if (sortBy === 'name-desc') {
                return nameB.localeCompare(nameA);
            }
        });

        sortedCards.forEach(card => {
            document.querySelector('.products').appendChild(card);
        });
    }
});
