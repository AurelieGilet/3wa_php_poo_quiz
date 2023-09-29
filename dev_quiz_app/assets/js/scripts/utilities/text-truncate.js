// Used to truncate text in the BO data tables (width not fixed, css ellipsis doesn't work)
function isTextToLong(text) {
    if (text.innerHTML.trim().length > 18) {
        return true;
    }

    return false;
}

function truncateText(text) {
    const truncatedText = text.innerHTML.trim().substring(0, 18) + "...";

    console.log(truncatedText);

    text.innerHTML = truncatedText;
}

function addTitleAttribute(text) {
    text.setAttribute("title", text.innerHTML.trim());
}

const textToTruncate = document.querySelectorAll('[data-truncate="true"]');

if (textToTruncate.length) {
    textToTruncate.forEach((text) => {
        if (isTextToLong(text)) {
            addTitleAttribute(text);
            truncateText(text);
        }
    });
}
