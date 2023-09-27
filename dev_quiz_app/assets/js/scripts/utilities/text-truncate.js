// Used to truncate text in the BO data tables
function isTextToLong(text) {
    if (text.innerHTML.length > 18) {
        return true;
    }

    return false;
}

function truncateText(text) {
    const truncatedText = text.innerHTML.substring(0, 18) + "...";

    text.innerHTML = truncatedText;
}

function addTitleAttribute(text) {
    text.setAttribute("title", text.innerHTML);
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
