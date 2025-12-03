(async () => {
    try {
        const dataToSend = { token: "09124" };
        const role = await postApi('/api/getRoleByToken', dataToSend);
        const name = await postApi('/api/getNameByToken', dataToSend);
        
        document.getElementById('role-name').textContent = role.role + " " + name.name;
        
    } catch (error) {
        console.error(error.message);
        document.getElementById('role-name').textContent = 'Error';
    }
})();