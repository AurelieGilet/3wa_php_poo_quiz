// Handle the display of the quiz questions and redirection to the score page when it's over
const answerQuestionsAjaxCall = () => {
    function displayNextQuestion(progress) {
        const selectedAnswer = document.querySelector("input[name=answer]:checked");

        if (selectedAnswer === null) {
            const errors = document.getElementById("errors");
            const errorMessage = "Vous devez sélectionner une réponse !";

            errors.innerHTML = errorMessage;
            return;
        }

        const answer = document.querySelector("input[name=answer]:checked").value;
        const gameBloc = document.getElementById("game-question");

        console.log(progress);
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    if (progress < 9) {
                        gameBloc.innerHTML = this.responseText;
                    } else {
                        const parser = new DOMParser();
                        const dom = parser.parseFromString(xhr.responseText, "text/html");

                        document.getElementsByTagName("body")[0].innerHTML =
                            dom.getElementsByTagName("body")[0].innerHTML;
                        window.history.pushState(null, "", this.responseURL);
                    }
                } else {
                    gameBloc.innerHTML =
                        "Une erreur s'est produite, merci de contacter l'administrateur du site.";
                }
            }
        };

        xhr.open("GET", "/jeu/categorie/reponse/" + answer);
        xhr.send();
    }

    const validateAnswerButton = document.getElementById("validate-answer");

    validateAnswerButton.addEventListener("click", (event) => {
        event.preventDefault();

        const gameProgress = document.getElementById("game-progress");

        if (gameProgress.dataset.progress <= 9) {
            displayNextQuestion(gameProgress.dataset.progress);
        }
    });
};

answerQuestionsAjaxCall();
