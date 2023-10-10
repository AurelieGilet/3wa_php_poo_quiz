// Handle the display of the user's game scores, filtered by category
const userScoreAjaxCall = () => {
    function filterUserScoresByCategory(button, pageNumber = 1) {
        const categoryId = button.dataset.categoryId;
        const scoresBloc = document.getElementById("category-scores");

        if (pageNumber === "false") {
            console.log('function', pageNumber);
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

    function addPaginationListener() {
        const prevButton = document.getElementById('pagination-prev');
        const nextButton = document.getElementById('pagination-next');

        console.log(prevButton);
        console.log(nextButton);

        if (prevButton) {
            const activeCategory = document.querySelector('.active[data-controls="user-score-filter"]');
            const pageNumber = prevButton.dataset.prevPage;
            console.log('PrevPageNumber', pageNumber);
            prevButton.addEventListener('click', () => filterUserScoresByCategory(activeCategory, pageNumber));
        }

        if (nextButton) {
            const activeCategory = document.querySelector('.active[data-controls="user-score-filter"]');
            const pageNumber = nextButton.dataset.nextPage;
            console.log('NextPageNumber', pageNumber);
            nextButton.addEventListener('click', () => filterUserScoresByCategory(activeCategory, pageNumber));
        }
        
    }

    addPaginationListener();

    const scoreFilters = document.querySelectorAll('[data-controls="user-score-filter"]');

    if (scoreFilters.length) {
        scoreFilters.forEach((button) => {
            button.addEventListener("click", () => filterUserScoresByCategory(button));
        });
    }
};

userScoreAjaxCall();
