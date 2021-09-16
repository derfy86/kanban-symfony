const listModule = {

    defaultErrorMessage: 'Désolé un problème est survenu avec les listes, veuillez réessayer ultérieurement',

    setBaseUrl: function(base_url){
        listModule.list_base_url = base_url + '/lists'
    },

    showAddListModal: function () {
        const addListModal = document.getElementById('addListModal');
        addListModal.classList.add('is-active');
    },

    getListsFromAPI: async function () {
        try {
            const response = await fetch(listModule.list_base_url);

            if (response.status !== 200) {
                const error = await response.json();
                throw error;
            }

            const lists = await response.json();
            for (const list of lists) {

                listModule.makeListInDOM(list.name, list.id);
                // for (const card of list.cards) {
                //   cardModule.makeCardInDOM(card);
                //     for (const tag of card.tags){
                //       tagModule.makeTagInDOM(tag)
                //     }
                // }
            }
            const cardList = document.querySelector('.card-lists');
            new Sortable(cardList, {
              onEnd: listModule.handleDropList
            });

        } catch (error) {
            alert(listModule.defaultErrorMessage);
            console.error(error);
        }
    },

    handleDropList: function (event) {
      listModule.updateAllLists();
    },
  
    updateAllLists: async function () {
  
      const lists = document.querySelectorAll('[list-id]');
   
      lists.forEach((list, listIndex) => {
        const listId = list.getAttribute('list-id');
        const position = listIndex
  
        const formData = new FormData();
        
        formData.set('position', position);
        try {
          fetch(`${listModule.list_base_url}/${listId}`, {
            method: 'PATCH',
            body: formData
          });
        } catch (error) {
          alert(listModule.defaultErrorMessage);
          console.error(error);
        }
      });
  
    },
  

    makeListInDOM: function (listName, listId) {
        const listTemplate = document.getElementById('template-list');
        const listTemplateContent = listTemplate.content;
        const newList = document.importNode(listTemplateContent, true);
        const newListTitle = newList.querySelector('h2');
        newListTitle.textContent = listName;

        newListTitle.addEventListener('dblclick', listModule.handleListTitleEdit);

        const form = newListTitle.nextElementSibling;
        form.addEventListener('submit', listModule.handleEditListForm);

        if (listId) {
            const blockList = newList.querySelector('.panel');
            blockList.setAttribute('list-id', listId);
            const idField = form.querySelector('input[name="id"]');
            idField.value = listId;
            const nameField = form.querySelector('input[name="name"]');
            nameField.value = listName;
        }

        const listContainer = document.querySelector('.card-lists');
        const button = newList.querySelector('.add-card-button');

        const buttonTrash = newList.querySelector('.buttonMoins');
        buttonTrash.addEventListener('click', listModule.deleteList);

        listContainer.append(newList);

        button.addEventListener('click', cardModule.showAddCardModal);
    },

    handleAddListForm: async function (event) {
      try {
        const formData = new FormData(event.target);
        console.log('list')
  
        const response = await fetch(listModule.list_base_url + '/add', {
          method: 'post',
          body: formData
        });
  
        const newListOrError = await response.json();
  
        if (response.status !== 200) {
          throw newListOrError;
        }
  
        listModule.makeListInDOM(newListOrError.name, newListOrError.id);
      } catch (error) {
        alert(listModule.defaultErrorMessage);
        console.error(error);
      }
    },

    handleListTitleEdit: function (event) {
      const currentTitle = event.target;
      currentTitle.classList.add('is-hidden');
      const form = currentTitle.nextElementSibling;
      form.classList.remove('is-hidden');
    },

    handleEditListForm: async function (event) {
      try {
        event.preventDefault();
  
        const formData = new FormData(event.target);
  
        const response = await fetch(`${listModule.list_base_url}/${formData.get('id')}`, {
          method: 'PATCH',
          body: formData
        });
  
        const newListOrError = await response.json();
  
        if (response.status !== 200) {
          throw newListOrError;
        }
        const currentList = event.target.closest('.panel');
  
        const currentTitle = currentList.querySelector('h2');
        currentTitle.textContent = newListOrError.name;
        currentTitle.classList.remove('is-hidden');
        const form = currentTitle.nextElementSibling;
        form.classList.add('is-hidden');
  
      } catch (error) {
        alert(listModule.defaultErrorMessage);
        console.error(error);
      }
    },

    deleteList: async function (event){
      const currentList = event.target.closest('[list-id]');
      const id = currentList.getAttribute("list-id");
      
      try {
          const response = await fetch(`${listModule.list_base_url}/${id}`, {
              method: 'DELETE',
          });
      
          currentList.remove();
          
          if (response.status !== 200) {
              throw listModule.defaultErrorMessage;
          }
          
      } catch (error) {
          alert(listdModule.defaultErrorMessage);
          console.error(error);
          }
      },

};