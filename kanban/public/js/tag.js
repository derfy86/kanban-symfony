const tagModule = {

    defaultErrorMessage: 'Désolé un problème est survenu avec les tags, veuillez réessayer ultérieurement',
  
    setBaseUrl: function (base_url) {
      tagModule.tag_base_url = base_url + '/tags'
    },
  
    getTagsFromAPI: async function () {
      try {
  
        const response = await fetch(tagModule.tag_base_url);
  
        if (response.status !== 200) {
          const error = await response.json();
          throw error;
        }
  
        const tags = await response.json();
        for (const tag of tags) {
          tagModule.makeTagInDOM(tag);
        }
  
        const card = document.querySelector('[card-id]');
        const tagList = document.querySelector('.tag-container');
  
        if (card) {
          new Sortable(tagList, {
            onEnd: function (event) {
  
              var test = event.item;
              tagModule.makeTagInCard(test)
            },
  
          });
        };
  
      } catch (error) {
        alert(tagModule.defaultErrorMessage);
        console.error(error);
      }
    },
  
  
    makeTagInCard: async (result) => {
  
  
      const tagId = result.getAttribute('tag-id');
  
  
      const card = event.target.closest('.box')
      const cardId = card.getAttribute('card-id');
      
  
      const formData = new FormData();
      formData.set('tag_id', tagId);
  
      if(cardId){
  
      try {
        const response = await fetch(`${cardModule.card_base_url}/${cardId}/tags`, {
          method: 'POST',
          body: formData
        });
  
        const tagFinal = await fetch(`${tagModule.tag_base_url}/${tagId}`)
  
        const find = await tagFinal.json();
  
        Object.defineProperty(find, "card_has_tag", {
          value: {
            card_id: cardId,
            tag_id: tagId
          }
        });
        find.set
  
  
        tagModule.makeTagInDOM(find);
      } catch (error) {
        alert(tagModule.defaultErrorMessage);
        console.error(error);
      };
    }
  
    },
  
    showEditTagsModal: function () {
      const editTagsModal = document.getElementById('addEditTagModal');
      editTagsModal.classList.add('is-active');
    },
  
    makeTagInDOM: function (tag) {
      let cardHasTag = tag.card_has_tag
  
      const tagTemplate = document.getElementById('template-tag');
      const tagTemplateContent = tagTemplate.content;
      const newTag = document.importNode(tagTemplateContent, true);
  
      const tagPoubelle = newTag.querySelector('.poubelle');
  
      const id = newTag.querySelector('[tag-id]')
      id.setAttribute('tag-id', tag.id)
  
      const newNameTag = newTag.querySelector('.p');
      newNameTag.textContent = tag.name;
  
      const blockTag = newTag.querySelector('.box');
      blockTag.setAttribute('tag-id', tag.id);
  
      const newTagBox = newTag.querySelector('.box');
      newTagBox.style.backgroundColor = tag.color;
  
      const form = newTag.querySelector('.f');
  
      const idField = form.querySelector('input[name="id"]');
      idField.value = tag.id;
  
      const nameField = form.querySelector('input[name="name"]');
      nameField.value = tag.name;
  
      const colorField = form.querySelector('input[name="color"]');
      colorField.value = tag.color;
  
      if (cardHasTag) {
        const card = document.querySelector('[card-id = "' + tag.card_has_tag.card_id + '"]')
        const tagContainer = card.querySelector('.tagCard');
        tagContainer.append(newTag);
      }
      if (cardHasTag === undefined) {
        const tagContainer = document.querySelector('.tag-container');
        tagContainer.append(newTag);
      };
  
      blockTag.addEventListener('click', function (event) {
        tagModule.handleTagTitleEdit(event)
      });
  
      form.addEventListener('submit', async function (event) {
        event.preventDefault();
        await tagModule.handleEditTagForm(event)
      });
  
      tagPoubelle.addEventListener('click', async function (event) {
        event.preventDefault();
        await tagModule.deletedTag(event)
      });
  
    },
  
    handleAddTagForm: async function (event) {
  
      const myFormFromDOM = event.target;
  
      const formData = new FormData(myFormFromDOM);
  
      let data = {
        name: formData.get('name'),
        color: formData.get('color')
      };
  
      try {
  
        const response = await fetch(`${tagModule.tag_base_url}`, {
          method: 'POST',
          body: formData,
        });
  
        const tagOrError = await response.json();
  
        if (response.status !== 200) {
          throw tagOrError;
        }
  
        tagModule.makeTagInDOM(tagOrError);
  
      } catch (error) {
        alert(tagModule.defaultErrorMessage);
        console.error(error);
      }
    },
  
    handleTagTitleEdit: function (event) {
  
      const box = event.target.closest('.box')
  
      const currentTitle = box.querySelector('.p')
  
      currentTitle.classList.add('is-hidden');
  
      const form = box.querySelector('[method="POST"]');
      form.classList.remove('is-hidden');
    },
  
    handleEditTagForm: async function () {
  
      try {
        const box = event.target.closest('[tag-id]');
  
        const tagId = box.getAttribute('tag-id');
  
        const form2 = box.querySelector('.f');
  
        const formData = new FormData(form2);
  
        const response = await fetch(`${tagModule.tag_base_url}/${formData.get('id')}`, {
          method: 'PATCH',
          body: formData
        });
  
        const newTagOrError = await response.json();
  
        if (response.status !== 200) {
          throw Error(newTagOrError);
        }
  
        const boxAll = document.querySelectorAll('[tag-id = "' + tagId + '"]')
        console.log(boxAll)
  
        for (const boxTag of boxAll) {
          const text = boxTag.querySelector('.p');
          text.textContent = newTagOrError.name;
          boxTag.style.backgroundColor = newTagOrError.color;
          if (text.classList.contains('is-hidden')) {
            text.classList.remove('is-hidden');
          };
        };
        form2.classList.add('is-hidden');
  
      } catch (error) {
        alert(app.defaultErrorMessage);
        console.error(error);
      }
    },
  
    deletedTag: async function (event) {
  
      try {
        const target = event.target.closest('[tag-id]');
  
        const tagId = target.getAttribute('tag-id');
  
  
        const response = await fetch(`${tagModule.tag_base_url}/${tagId}`, {
          method: 'DELETE',
        });
  
        const newTagOrError = await response.json();
        const boxAll = document.querySelectorAll('[tag-id = "' + tagId + '"]')
  
        for (const box of boxAll) {
          box.remove();
        };
  
        if (response.status !== 200) {
          throw Error(newTagOrError);
        }
      } catch (error) {
        alert(tagModule.defaultErrorMessage);
        console.error(error);
      }
    },
  }