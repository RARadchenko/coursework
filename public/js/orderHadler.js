function openOrderModal(item) {

    if (document.getElementById('dynamic-modal-backdrop')) {
        return;
    }

    const backdrop = document.createElement('div');
    backdrop.id = 'dynamic-modal-backdrop';


    const modal = document.createElement('div');
    modal.id = 'dynamic-modal';
    modal.classList.add('small');

    modal.innerHTML = `
        <h3>${item.name}</h3>

        <p>
            Кількість:
            <strong><span id="order-value">${item.min}</span> ${item.unit}</strong>
        </p>

        <input 
            type="range" 
            min="${item.min}" 
            max="${item.max}" 
            value="${item.min}" 
            step="1"
            id="order-range"
        >

        <div class="modal-actions">
            <button id="order-confirm">Замовити</button>
            <button id="order-cancel">Скасувати</button>
        </div>
    `;

    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);

    const range = modal.querySelector('#order-range');
    const valueLabel = modal.querySelector('#order-value');

    range.addEventListener('input', () => {
        valueLabel.textContent = range.value;
    });

    modal.querySelector('#order-cancel').onclick = () => {
        backdrop.remove();
    };

    modal.querySelector('#order-confirm').onclick = async () => {
        const payload = {
            product_id: item.id,
            amount: range.value,
            price: item.price,
            token: sessionStorage.getItem('authToken')
        };

        try {
            await postApi('/api/orderAdd', payload, false);
        } catch (e) {
            console.error(e);
        }

        backdrop.remove();
    };
}
