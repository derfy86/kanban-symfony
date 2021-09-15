const app = {

    base_url: 'http://localhost:8000',
  
    defaultErrorMessage: 'Désolé un problème est survenu, veuillez réessayer ultérieurement',
  
  
    init: function () {
      console.log('app.init !');
  
      listModule.setBaseUrl(app.base_url);
      cardModule.setBaseUrl(app.base_url);
      tagModule.setBaseUrl(app.base_url);
  
      app.addListenerToActions();
      listModule.getListsFromAPI();
      tagModule.getTagsFromAPI();
    },
  
    addListenerToActions: function () {
      const addListButton = document.getElementById('addListButton');
      addListButton.addEventListener('click', listModule.showAddListModal);
  
      const closeModalButtons = document.querySelectorAll('.close');
      for (const button of closeModalButtons) {
        button.addEventListener('click', app.hideModals);
      }
  
      const addListForm = document.querySelector('#addListModal form');
      addListForm.addEventListener('submit', async function(event){
        event.preventDefault();
        await listModule.handleAddListForm(event);
        app.hideModals();
      });
  
      const addCardButtons = document.querySelectorAll('.add-card-button');
      for (const button of addCardButtons) {
        button.addEventListener('click', cardModule.showAddCardModal);
      }
  
      const addCardForm = document.querySelector('#addCardModal form');
      addCardForm.addEventListener('submit', async function(event){
        event.preventDefault();
        await cardModule.handleAddCardForm(event);
        app.hideModals();
      });
  
      const editTagsButton = document.getElementById('editTagsButton');
      editTagsButton.addEventListener('click', tagModule.showEditTagsModal);
  
      const editTagForm = document.querySelector('#addEditTagModal form');
      editTagForm.addEventListener('submit', async function(event){
        event.preventDefault();
        await tagModule.handleAddTagForm(event);
        app.hideModals();
      });
    },
  
    hideModals: function () {
      const modals = document.querySelectorAll('.modal');
      for (const modal of modals) {
        modal.classList.remove('is-active');
      }
    }
  
  };
  
  document.addEventListener('DOMContentLoaded', app.init);