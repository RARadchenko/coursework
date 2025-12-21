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

                if (response.viewMap === "lineCurrentOrder") {
    contentSection.style.flexDirection = 'column';

    // 1. Генеруємо HTML
    contentSection.innerHTML = response.content.map(row => {
        // Фільтруємо ключі, щоб не виводити item_id у тегах <p>
        const fields = Object.entries(row)
            .filter(([key]) => key !== 'item_id') 
            .map(([key, value]) => `<p>${value ?? '---'}</p>`)
            .join('');

        // Додаємо item_id у data-id кнопки
        return `
            <div class="line">
                ${fields} 
                <button class="delete-item-btn" data-id="${row.item_id}">X</button>
            </div>`;
    }).join('');

    contentSection.onclick = async (event) => {
        if (event.target.classList.contains('delete-item-btn')) {
            const btn = event.target;
            const itemId = btn.getAttribute('data-id');
            const parentLine = btn.closest('.line');
            if (confirm('Видалити цей товар із замовлення?')) {
                try {

                    const dataToSend = {
                        orderItem: itemId,
                        token: sessionStorage.getItem('authToken')
                    };
                    await postApi('/api/orderItemDelete', dataToSend);
                    parentLine.remove();

                } catch (error) {
                    console.error('Помилка запиту:', error);
                }
            }
        }
    };
}

                if (response.viewMap === "modal") {

    openDynamicModal(response.content, (formData) => {
        
    });
    }
    if (response.viewMap === "modalAddItem") {
    openAddProductModal(response.content, (formData) => {
        
    });
    }
    if (response.viewMap === "modalEditItem") {
    openEditProductModal(response.content, (formData) => {
    
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
            category: content['Категорія'][i],
            is_active: content['Відображення'][i]
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
        if(item.is_active == 0){
            return categoryHeader + `<div class="card" style="background-color: #ffecec">${fields}</div>`;
        }
        else{
            return categoryHeader + `<div class="card">${fields}</div>`;
        }
    }).join(''); 

}

if (response.viewMap === "cardsPositionsOrder") {
    contentSection.style.flexDirection = 'row';
    
    const content = response.content;
    const count = content['Назва'].length;
    
    const items = [];
    for (let i = 0; i < count; i++) {
        items.push({
            image_url: content['image_url'][i],
            name: content['Назва'][i],
            price: content['Ціна'][i],
            min: content['Мінімум'][i],
            max: content['Максимум'][i],
            unit: content['Вимір'][i],
            category: content['Категорія'][i],
            id: content['Ідентифікатор'][i],
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
            <p class="card-price">${item.price} грн</p>
            <button content="${item.name}">Замовити</button>
        `;
            return categoryHeader + `<div class="card">${fields}</div>`;
    }).join(''); 
    contentSection.addEventListener('click', e => {
    if (!e.target.matches('button')) return;

    const card = e.target.closest('.card');
    if (!card) return;

    const itemName = card.querySelector('.card-title').textContent;

    const item = items.find(i => i.name === itemName);
    if (!item) return;

    openOrderModal(item);
});

}
            }
             catch (error) {
                console.error(error.message);
            }
        }
    });
});