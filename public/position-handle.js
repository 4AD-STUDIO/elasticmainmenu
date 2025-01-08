

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
            const beginId = draggedElement.querySelector(".column-emm_position").innerText;
            const endId = target.querySelector(".column-emm_position").innerText;
            updatePositions(beginId, endId);
        }
        categoriesContainer.querySelectorAll('.draggable').forEach(el => el.classList.remove('drag-over'));
    });

    categoriesContainer.addEventListener('dragend', () => {
        draggedElement = null;
    });

    function updatePositions(beginId, endId) {
        const url = window.token_4ad;
        console.log(token);
        // const csrfToken = document.querySelector('input[name="_token"]').value;
        // const url = "http://localhost:8080/admin4577/index.php/modules/elastic-mainmenu/updatepositions/22/22&token=" + token;



// console.log(token);


        // const url = `http://localhost:8080/admin4577/index.php/modules/elastic-mainmenu/updatepositions/${beginId}/${endId}&token=${token}`;
//localhost:8080/admin4577/index.php/modules/elastic-mainmenu/test/22/22&token=687c89dd98fc02419f5eae1cee4c5bce#/dashboard
 


        // console.log();
        fetch(url)
        .then(response => response.text())
        .then(data => {
            // messageDiv.innerHTML = data;
            // activateMessage('success');
            console.log(data);
        })
        .catch(error => {
            // messageDiv.innerHTML = 'Błąd: ' + error;
            // activateMessage('error');
            console.log('Błąd: '+error);
        });
    }

 
    
};





