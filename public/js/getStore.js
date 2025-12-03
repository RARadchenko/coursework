(async () => {
    try {
        const dataToSend = { token: "09124" };
        const json = await postApi('/api/getStoreByToken', dataToSend);
        
        document.getElementById('store-code').textContent = json.store;
        
    } catch (error) {
        console.error(error.message);
        document.getElementById('store-code').textContent = 'Error';
    }
})();