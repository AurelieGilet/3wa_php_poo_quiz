// Custom select animation

// Handle clicks outside of the custom select (to close it)
function handleClickOutsideSelect(event) {
    const customSelect = document.querySelector(".custom-select");

    if (!customSelect.contains(event.target)) {
        customSelect.classList.remove("open");

        document.removeEventListener("click", handleClickOutsideSelect);
    }
}

// Change the text of the selected option
function changeSelectedOption(option, customSelectOptions) {
    customSelectOptions.forEach((selectOption) => {
        selectOption.classList.remove("active");
    });

    option.classList.add("active");

    const selectTrigger = document.querySelector(".custom-select__trigger span");
    if (selectTrigger) {
        selectTrigger.textContent = option.textContent;
    }
}

const customSelectWrapper = document.querySelector(".custom-select__wrapper");
const customSelect = document.querySelector(".custom-select");

if (customSelectWrapper && customSelect) {
    customSelectWrapper.addEventListener("click", function () {
        customSelect.classList.toggle("open");
        document.addEventListener("click", handleClickOutsideSelect);
    });
}

const customSelectOptions = document.querySelectorAll(".select-option");

if (customSelectOptions.length) {
    customSelectOptions.forEach((option) => {
        option.addEventListener("click", () => changeSelectedOption(option, customSelectOptions));
    });
}
