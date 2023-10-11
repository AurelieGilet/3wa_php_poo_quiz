// Handle the display in the BO of the questions, filterer by category
const adminQuestionsAjaxCall = () => {
    function filterQuestionsByCategory(button, pageNumber = 1) {
        const categoryId = button.dataset.categoryId;
        const questionBloc = document.getElementById("category-questions");

        if (pageNumber === "false") {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    questionBloc.innerHTML = this.responseText;
                    addPaginationListener();
                } else {
                    questionBloc.innerHTML =
                        "Une erreur s'est produite, merci de contacter l'administrateur du site.";
                }
            }
        };
        xhr.open("GET", "/admin/questions/" + categoryId + "?page=" + pageNumber);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send();
    }

    const categoriesFilters = document.querySelectorAll('[data-controls="category-filter"]');

    if (categoriesFilters.length) {
        categoriesFilters.forEach((button) => {
            button.addEventListener("click", () => filterQuestionsByCategory(button));
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
        let activeCategory = document.querySelector('.selected[data-controls="category-filter"]');

        if (currentDisplayWidth > 991) {
            // Desktop category select
            activeCategory = document.querySelector('.active[data-controls="category-filter"]');
        }

        // Make sure it's the admin questions pagination buttons
        if (prevButton && categoriesFilters.length) {
            const pageNumber = prevButton.dataset.prevPage;

            prevButton.addEventListener('click', () => filterQuestionsByCategory(activeCategory, pageNumber));
        }

        if (nextButton && categoriesFilters.length) {
            const pageNumber = nextButton.dataset.nextPage;

            nextButton.addEventListener('click', () => filterQuestionsByCategory(activeCategory, pageNumber));
        }
    }

    addPaginationListener();
};

adminQuestionsAjaxCall();
