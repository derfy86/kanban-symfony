const cardModule = {

    setBaseUrl: function (base_url) {
      cardModule.card_base_url = base_url + '/cards'
    },
  
    showAddCardModal: function (event) {
      const addCardModal = document.getElementById('addCardModal');
      addCardModal.classList.add('is-active');
      const currentList = event.target.closest('.panel');
      const listId = currentList.getAttribute('list-id');
      const listIdField = addCardModal.querySelector('[name="list_id"]');
      listIdField.value = listId;
    },
  
    makeCardInDOM: function (card) {
      const cardTemplate = document.getElementById('template-card');
      const cardTemplateContent = cardTemplate.content;
      const newCard = document.importNode(cardTemplateContent, true);
      const newCardContent = newCard.querySelector('.content');
      newCardContent.textContent = card.content;
  
      const listContainer = document.querySelector('[list-id="' + card.list_id + '"] .panel-block');
      if (card) {
        new Sortable(listContainer, {});
      };
  
      const form = newCard.querySelector('.f');
  
      const blockCard = newCard.querySelector('.box');
  
      blockCard.setAttribute('card-id', card.id);
  
      const idField = form.querySelector('input[name="id"]');
      idField.value = card.id;
  
      const nameField = form.querySelector('input[name="content"]');
      nameField.value = card.content;
  
      const colorField = form.querySelector('input[name="color"]');
      colorField.value = card.color;
  
      const newCardContentPencil = newCard.querySelector('.i');
  
      newCardContentPencil.addEventListener('click', function () {
        cardModule.handleCardTitleEdit(event)
      });
  
      const cardPoubelle = newCard.querySelector('.poubelle');
  
      cardPoubelle.addEventListener('click', async function (event) {
        event.preventDefault();
        await cardModule.deletedCard(event)
      });
  
      form.addEventListener('submit', async function (event) {
        event.preventDefault();
        await cardModule.handleEditCardForm(event)
      });
  
      const newCardBox = newCard.querySelector('.box');
      newCardBox.style.backgroundColor = card.color;
  
      listContainer.append(newCard);
    },
  
    handleAddCardForm: async function (event) {
  
      try {
        
        const formData = new FormData(event.target);
  
        // let data = {
        //   content: formData.get('content'),
        //   list_id: formData.get('list_id'),
        //   color: formData.get('color')
        // };
        const response = await fetch(cardModule.card_base_url + '_add', {
          method: 'POST',
          body: formData
        });
  
        const newCardOrError = await response.json();
        if (response.status !== 200) {
          throw new Error(newCardOrError);
        }
  
        cardModule.makeCardInDOM(newCardOrError);
  
      } catch (error) {
        alert(app.defaultErrorMessage);
        console.error(error);
      }
    },
  
    handleCardTitleEdit: function (event) {
  
      const box = event.target.closest('.box')
      const currentTitle = box.querySelector('.p')
  
      currentTitle.classList.add('is-hidden');
  
      const form = box.querySelector('[method="POST"]');
      form.classList.remove('is-hidden');
    },
  
    handleEditCardForm: async () => {
  
      try {
        const box = event.target.closest('.box');
  
        const form2 = box.querySelector('.f');
  
        const formData = new FormData(form2);
  
        const response = await fetch(`${cardModule.card_base_url}/${formData.get('id')}`, {
          method: 'PATCH',
          body: formData
        });
  
        const newTagOrError = await response.json();
  
        if (response.status !== 200) {
          throw Error(newTagOrError);
        }
        
        box.style.backgroundColor = newTagOrError.color;
  
        const currentTitle = box.querySelector('.p');
        currentTitle.textContent = newTagOrError.content;
  
        currentTitle.classList.remove('is-hidden');
        form2.classList.add('is-hidden');
  
      } catch (error) {
        alert(app.defaultErrorMessage);
        console.error(error);
      }
    },
  
    deletedCard: async function (event) {
  
      try {
        const box = event.target.closest('[card-id]');
    
        const cardId = box.getAttribute('card-id');
   
  
        const response = await fetch(`${cardModule.card_base_url}/delete/${cardId}`, {
          method: 'DELETE',
        });
  
        box.remove();
  
        if (response.status !== 200) {
          throw Error(newTagOrError);
        }
      } catch (error) {
        alert(app.defaultErrorMessage);
        console.error(error);
      }
    },
  };