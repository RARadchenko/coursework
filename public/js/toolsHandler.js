document.addEventListener('DOMContentLoaded', () => {
    const ulElement = document.getElementById('avaliable-instruments');
    const infoDisplay = document.getElementById('info-display');

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
                token: "09124"
            };

            try {
                const apiEndpoint = '/api/changeContent'; 
                const response = await postApi(apiEndpoint, dataToSend);
                const contentHeader = document.getElementById('content-header');
                contentHeader.textContent = response.contentHeader;
                
                
            } catch (error) {
                console.error(error.message);
            }
        }
    });
});