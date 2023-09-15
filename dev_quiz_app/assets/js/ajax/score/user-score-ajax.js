// Handle the display of the user's game scores, filtered by category
const userScoreAjaxCall = () => {
    function filterUserScoresByCategory(button) {
        const categoryId = button.dataset.categoryId;
        const scoresBloc = document.getElementById("category-scores");

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    scoresBloc.innerHTML = this.responseText;
                } else {
                    scoresBloc.innerHTML =
                        "Une erreur s'est produite, merci de contacter l'administrateur du site.";
                }
            }
        };
        xhr.open("GET", "/espace-utilisateur/scores/" + categoryId);
        xhr.send();
    }

    const scoreFilters = document.querySelectorAll('[data-controls="user-score-filter"]');

    if (scoreFilters.length) {
        scoreFilters.forEach((button) => {
            button.addEventListener("click", () => filterUserScoresByCategory(button));
        });
    }
};

userScoreAjaxCall();
