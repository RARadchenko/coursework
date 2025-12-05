const tokenValue = sessionStorage.getItem('authToken');
(async () => {
    if (!tokenValue || tokenValue === "") {
        return;
    }
    try {
        const dataToSend = { token: sessionStorage.getItem('authToken') };
        const role = await postApi('/api/getRoleByToken', dataToSend);
        const name = await postApi('/api/getNameByToken', dataToSend);
        
        document.getElementById('role-name').textContent = role.role + " " + name.name;
        
    } catch (error) {
        console.error(error.message);
        document.getElementById('role-name').textContent = 'Error';
    }
})();