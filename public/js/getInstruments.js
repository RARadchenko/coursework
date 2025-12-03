(async () => {
    const ulElement = document.getElementById('avaliable-instruments');
    try {
        const dataToSend = { token: "09124" };
        const response = await postApi('/api/getInstruments', dataToSend);

        const toolNames = response.tools;
        const actionIds = response.action_view;

        if (!toolNames || !actionIds || toolNames.length !== actionIds.length) {
            throw new Error("Некоректний формат даних: масиви інструментів не відповідають.");
        }

        ulElement.innerHTML = '';
        
        toolNames.forEach((name, index) => {

            const actionId = actionIds[index];
            ulElement.innerHTML += `<li data-action="${actionId}">${name}</li>`;
        });

        const firstListItem = ulElement.querySelector('li');
        firstListItem.click();
        
    } catch (error) {
        console.error(error.message);
        ulElement.textContent = 'Помилка завантаження інструментів.';
    }
})();