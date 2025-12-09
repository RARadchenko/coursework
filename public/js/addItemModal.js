function openAddProductModal(fieldsObject, onSubmit) {
    const backdrop = document.createElement('div');
    backdrop.id = 'dynamic-modal-backdrop';

    const modal = document.createElement('div');
    modal.id = 'dynamic-modal';

    let actionVal;

    Object.entries(fieldsObject).forEach(([key, value]) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'modal-field';

        const label = document.createElement('label');
        label.textContent = key;

        let field;

        // --- SELECT ---
        if (typeof value === "object" && value !== null && !Array.isArray(value)) {
            field = document.createElement('select');
            field.name = key;
            Object.entries(value).forEach(([val, text]) => {
                const option = document.createElement('option');
                option.value = val;
                option.textContent = text;
                field.appendChild(option);
            });
        }

        // --- ACTION ---
        else if (key === 'action') {
            actionVal = value;
            return; // skip creating field
        }

        // --- FILE INPUT (нове!) ---
        else if (value === 'file' || key.toLowerCase().includes('photo') || key.toLowerCase().includes('фото')) {
            field = document.createElement('input');
            field.type = 'file';
            field.name = key;
            field.accept = 'image/*';
        }

        // --- TEXT / PASSWORD ---
        else {
            field = document.createElement('input');
            field.type = key.toLowerCase().includes('пароль') ? 'password' : 'text';
            field.name = key;
            field.placeholder = value ?? '';
        }

        wrapper.appendChild(label);
        wrapper.appendChild(field);
        modal.appendChild(wrapper);
    });

    // --- Buttons ---
    const btnOk = document.createElement('button');
    btnOk.textContent = 'OK';
    const btnCancel = document.createElement('button');
    btnCancel.textContent = 'Скасувати';

    modal.appendChild(btnOk);
    modal.appendChild(btnCancel);

    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);

    // --- Submit handler ---
    btnOk.onclick = () => {
        const isMultipart = [...modal.querySelectorAll('input')]
            .some(input => input.type === 'file');

        let payload;

        if (isMultipart) {
            // Якщо є фото → FormData
            payload = new FormData();
            modal.querySelectorAll('input, select').forEach(input => {
                if (input.type === 'file') {
                    if (input.files.length > 0) {
                        payload.append(input.name, input.files[0]);
                    }
                } else {
                    payload.append(input.name, input.value);
                }
            });

        } else {
            // Звичайний JSON
            payload = {};
            modal.querySelectorAll('input, select').forEach(input => {
                payload[input.name] = input.value;
            });
        }

        (async () => {
            try {
                await postApi('/api/' + actionVal, payload, isMultipart);        
            } catch (error) {
                console.error(error.message);
            }
        })();

        backdrop.remove();
        onSubmit(payload);

        const ulElement = document.getElementById('avaliable-instruments');
        const firstListItem = ulElement.querySelector('li');
        firstListItem.click();
    };

    // --- Cancel ---
    btnCancel.onclick = () => {
        backdrop.remove();
        const ulElement = document.getElementById('avaliable-instruments');
        const firstListItem = ulElement.querySelector('li');
        firstListItem.click();
    };
}
