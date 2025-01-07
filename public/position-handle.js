

//dodac event ladowania

window.onload = (event) => {
    const categoriesContainer = document.querySelector("#category_grid_table tbody");
    const categoryItems = document.querySelectorAll("#category_grid_table tbody tr");

    const loadInterval = setInterval(initColumn, 200);
    function initColumn() {


        if(categoryItems.length !== 0) {
            clearInterval(loadInterval); 
            addPositionCels(categoryItems);
        }
    }
    function addPositionCels(categoryItems) {
        categoryItems.forEach( item => {
            item.append(createPositionElement());
            item.classList.add("draggable");
            item.draggable = 'true';
        });
    }
    function createPositionElement() {
        const newPositionElement = document.createElement("td");
        newPositionElement.classList.add("elasticmainmenu__position");
        newPositionElement.innerHTML = '⠿';
        return newPositionElement;
    }


    // ------------------------


    categoriesContainer.addEventListener('dragstart', (e) => {
        if (e.target.closest('.draggable')) {
            draggedElement = e.target.closest('.draggable');
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    categoriesContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        const target = e.target.closest('.draggable');
        if (target && target !== draggedElement) {
            target.classList.add('drag-over');
        }
    });

    categoriesContainer.addEventListener('dragleave', (e) => {
        const target = e.target.closest('.draggable');
        if (target) {
            target.classList.remove('drag-over');
        }
    });

    categoriesContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        const target = e.target.closest('.draggable');
        if (target && target !== draggedElement) {
            categoriesContainer.insertBefore(draggedElement, target.nextSibling);
        }
        categoriesContainer.querySelectorAll('.draggable').forEach(el => el.classList.remove('drag-over'));
    });

    categoriesContainer.addEventListener('dragend', () => {
        draggedElement = null;
    });



 
    
};





