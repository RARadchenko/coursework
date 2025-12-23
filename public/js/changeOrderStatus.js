document.addEventListener('change', async (event) => {
    const select = event.target;

    if (!select.classList.contains('order-status-select')) return;

    const orderItemId = select.dataset.orderId;
    const newStatus = select.value;

    try {
        await postApi('/api/changeOrderStatus', {
            order: orderItemId,
            status: newStatus,
            token: sessionStorage.getItem('authToken')
        });
    } catch (error) {
        console.error('Помилка запиту:', error);
    }
});
