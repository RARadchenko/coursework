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
        
        // перетворюємо об'єкт у список <p>
        const fields = Object.entries(row)
            .map(([key, value]) => `<p>${value ?? '---'}</p>`)
            .join('');

        return `<div class="line">${fields}</div>`;
    }).join('');
}
                
            } catch (error) {
                console.error(error.message);
            }
        }
    });
});