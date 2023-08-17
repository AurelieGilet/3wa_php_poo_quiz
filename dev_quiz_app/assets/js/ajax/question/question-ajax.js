const questionAjaxCall = () => {

    function filterQuestionsByCategory(button) {
        const categoryId = button.dataset.categoryId;
        const questionBloc = document.getElementById('category-questions');

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    questionBloc.innerHTML = this.responseText;
                } else {
                    questionBloc.innerHTML = "Une erreur s'est produite, merci de contacter l'administrateur du site.";
                }
            }
        }
        xhr.open("GET", "/admin/questions/" + categoryId);
        xhr.send();
    }

    const categoriesFilters = document.querySelectorAll('[data-controls="category-filter"]');

    categoriesFilters.forEach((button) =>  {
        button.addEventListener('click', () => filterQuestionsByCategory(button));
    });
}

questionAjaxCall();