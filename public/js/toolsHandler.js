document.addEventListener('DOMContentLoaded', () => {
    const ulElement = document.getElementById('avaliable-instruments');
    const infoDisplay = document.getElementById('info-display');
    const contentSection = document.getElementById('content-section');

    ulElement.addEventListener('click', async (event) => {
        const clickedItem = event.target.closest('li');
        
        if (clickedItem) {
            
            const actionId = clickedItem.dataset.action; 
            const toolName = clickedItem.textContent;

            if (!actionId) return;

            ulElement.querySelectorAll('li').forEach(li => {
                li.classList.remove('selected');
            });
            clickedItem.classList.add('selected');


            const dataToSend = {
                action: actionId,
                token: sessionStorage.getItem('authToken')
            };

            try {
                const apiEndpoint = '/api/changeContent'; 
                const response = await postApi(apiEndpoint, dataToSend);
                const contentHeader = document.getElementById('content-header');
                contentHeader.textContent = response.contentHeader;


                
                if (response.viewMap === "line") {
                    contentSection.style.flexDirection = 'column'
    contentSection.innerHTML = response.content.map(row => {
        
        const fields = Object.entries(row)
            .map(([key, value]) => `<p>${value ?? '---'}</p>`)
            .join('');

            return `<div class="line">${fields}</div>`;
                }).join('');
                }
                if (response.viewMap === "modal") {

    openDynamicModal(response.content, (formData) => {
        
    });
    }
    if (response.viewMap === "modalAddItem") {

    openAddProductModal(response.content, (formData) => {
        
    });
    }

if (response.viewMap === "cardsPositions") {
    contentSection.style.flexDirection = 'row';
    
    const content = response.content;
    const count = content['Назва'].length;
    
    const items = [];
    for (let i = 0; i < count; i++) {
        items.push({
            image_url: content['image_url'][i],
            name: content['Назва'][i],
            price: content['Ціна'][i],
            rule: content['Правило'][i],
            category: content['Категорія'][i]
        });
    }

    let previousCategory = null; 
    
    contentSection.innerHTML = items.map(item => {
        let categoryHeader = '';
        
        if (item.category !== previousCategory) {
            categoryHeader = `<p class="category-header">${item.category}</p>`;
            previousCategory = item.category; 
        }

        const fields = `
            <img src="${item.image_url.replace(/\\/g, '')}" alt="${item.name}"> 
            <p class="card-title">${item.name}</p>
            <p class="card-rule">${item.rule}</p>
            <p class="card-price">${item.price} грн</p>
        `;
        
        return categoryHeader + `<div class="card">${fields}</div>`;
    }).join(''); 

}
            }
             catch (error) {
                console.error(error.message);
            }
        }
    });
});