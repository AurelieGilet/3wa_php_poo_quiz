// Canvas used in user scores and admin questions templates

const categoriesContainer = document.getElementById("desktop-categories");
const canvas = document.getElementById("canvas");

if (categoriesContainer && canvas) {
    // We want the canvas to have the same height as the categories container (which is variable)
    const canvasWidth = canvas.offsetWidth;
    const canvasHeight = categoriesContainer.offsetHeight;

    canvas.setAttribute("width", canvasWidth);
    canvas.setAttribute("height", canvasHeight);

    let firstLineHeight = getFirstLineHeight(categoriesContainer);

    const ctx = canvas.getContext("2d");

    ctx.strokeStyle = "#00ffff";
    ctx.lineWidth = "2";

    function drawLines(firstLineHeight) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.beginPath();

        // First horizontal line
        ctx.moveTo(0, firstLineHeight);
        ctx.lineTo(canvasWidth / 2, firstLineHeight);
        ctx.stroke();

        // Vertical line
        ctx.moveTo(canvasWidth / 2, firstLineHeight);
        ctx.lineTo(canvasWidth / 2, canvasHeight / 2);
        ctx.stroke();

        // Second horizontal line
        ctx.moveTo(canvasWidth / 2, canvasHeight / 2);
        ctx.lineTo(canvasWidth, canvasHeight / 2);
        ctx.stroke();
    }

    drawLines(firstLineHeight);

    /**
     * This is used to know the distance between the top of the container and the middle of
     * the category button from where the horizontal line must start
     */
    function getFirstLineHeight(categoriesContainer) {
        const activeCategory = categoriesContainer.querySelector(".active");
        const offsetTop = activeCategory.offsetTop;
        const categoryHeight = activeCategory.offsetHeight;

        return offsetTop + categoryHeight / 2;
    }

    categoriesContainer.addEventListener("click", () => {
        firstLineHeight = getFirstLineHeight(categoriesContainer);
        drawLines(firstLineHeight);
    });

}