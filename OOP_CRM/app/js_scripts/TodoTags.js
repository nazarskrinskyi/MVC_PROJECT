const tagInput = document.querySelector('#tag-input');
const tagsContainer = document.querySelector('.tags-container');
const hiddenTags = document.querySelector('#hidden-tags');

function createTag(text) {
    const tag = document.createElement('div');
    tag.classList.add('tag');
    const tagText = document.createElement('span');
    tagText.textContent = text;

    const closeButton = document.createElement('button');
    closeButton.innerHTML = '&times;';

    closeButton.addEventListener('click', () => {
        tagsContainer.removeChild(tag);
        updateHiddenTags();
    });

    tag.appendChild(tagText);
    tag.appendChild(closeButton);

    return tag;
}

function updateHiddenTags(){
    const tags = tagsContainer.querySelectorAll('.tag span');
    const tagText = Array.from(tags).map(tag => tag.textContent);
    hiddenTags.value = tagText.join(',');
}

tagInput.addEventListener('input', (e) => {
    if(e.target.value.includes(',')){
        const tagText = e.target.value.slice(0, -1).trim();
        if (tagText.length > 1) {
            const tag = createTag(tagText);
            tagsContainer.insertBefore(tag, tagInput);
            updateHiddenTags();
        }
        e.target.value = '';
    }
});

tagsContainer.querySelectorAll('.tag button').forEach(button =>{
    button.addEventListener('click', () => {
        tagsContainer.removeChild(button.parentElement);
        updateHiddenTags();
    });
});