// Handle the display of the user's game scores, filtered by category
const userScoreAjaxCall = () => {
    function filterUserScoresByCategory(button, pageNumber = 1) {
        const categoryId = button.dataset.categoryId;
        const scoresBloc = document.getElementById("category-scores");

        if (pageNumber === "false") {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    scoresBloc.innerHTML = this.responseText;
                    addPaginationListener();

                } else {
                    scoresBloc.innerHTML =
                        "Une erreur s'est produite, merci de contacter l'administrateur du site.";
                }
            }
        };
        xhr.open("GET", "/espace-utilisateur/scores/" + categoryId + "?page=" + pageNumber);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send();
    }

    const scoreFilters = document.querySelectorAll('[data-controls="user-score-filter"]');

    if (scoreFilters.length) {
        scoreFilters.forEach((button) => {
            button.addEventListener("click", () => filterUserScoresByCategory(button));
        });
    }

    function addPaginationListener() {
        const prevButton = document.getElementById('pagination-prev');
        const nextButton = document.getElementById('pagination-next');

        /**
         * To avoid confusion between the mobile end desktop display,
         * we check the window width to know which elements to query.
         */
        const currentDisplayWidth = window.innerWidth;

        // Mobile category select
        let activeCategory = document.querySelector('.selected[data-controls="user-score-filter"]');

        if (currentDisplayWidth > 991) {
            // Desktop category select
            activeCategory = document.querySelector('.active[data-controls="user-score-filter"]');
        }

        if (prevButton && scoreFilters.length) {
            const pageNumber = prevButton.dataset.prevPage;

            prevButton.addEventListener('click', () => filterUserScoresByCategory(activeCategory, pageNumber));
        }

        // Make sure it's the user score pagination buttons
        if (nextButton && scoreFilters.length) {
            const pageNumber = nextButton.dataset.nextPage;

            nextButton.addEventListener('click', () => filterUserScoresByCategory(activeCategory, pageNumber));
        }
    }

    addPaginationListener();
};

userScoreAjaxCall();
