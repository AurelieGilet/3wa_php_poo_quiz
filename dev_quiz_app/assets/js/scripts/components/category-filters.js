//Add or remove the active class to the categories filter categoryFilterButtons
function changeActiveCategory(button, categoryFilterButtons) {
    categoryFilterButtons.forEach((filterButton)=> {
        filterButton.classList.remove('active')
    });

    button.classList.add('active');
}

const categoryFilterButtons = document.querySelectorAll('[data-component="category-filter"]');

if (categoryFilterButtons.length) {
    categoryFilterButtons.forEach((button) => {
        button.addEventListener('click', () => 
            changeActiveCategory(button, categoryFilterButtons)
        );
    });
}