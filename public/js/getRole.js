(async () => {
    try {
        const dataToSend = { token: "09124" };
        const json = await postApi('/api/getRoleByToken', dataToSend);
        
        document.getElementById('role-code').textContent = json.role;
        
    } catch (error) {
        console.error(error.message);
        document.getElementById('store-code').textContent = 'Error';
    }
})();