function openDynamicModal(fieldsObject, onSubmit) {
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

        if (typeof value === "object" && value !== null) {
            
            field = document.createElement('select');
            field.name = key;
            Object.entries(value).forEach(([val, text]) => {
                const option = document.createElement('option');
                option.value = val;
                option.textContent = text;
                field.appendChild(option);
            });
        }
        
        else if(key == 'action'){
            actionVal = value;
            return;
        }
        
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

    //кнопки
    const btnOk = document.createElement('button');
    btnOk.textContent = 'OK';
    const btnCancel = document.createElement('button');
    btnCancel.textContent = 'Скасувати';

    modal.appendChild(btnOk);
    modal.appendChild(btnCancel);

    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);

    // Обробники кнопок
    btnOk.onclick = () => {
        const data = {};
        modal.querySelectorAll('input, select').forEach(input => {
            data[input.name] = input.value;
        });
        
(async () => {
    try {
        await postApi('/api/' + actionVal, data);        
        
    } catch (error) {
        console.error(error.message);
    }
})();

        backdrop.remove();
        onSubmit(data);
        const ulElement = document.getElementById('avaliable-instruments');
        const firstListItem = ulElement.querySelector('li');
        firstListItem.click();
    };

    btnCancel.onclick = () => {
        backdrop.remove();
        const ulElement = document.getElementById('avaliable-instruments');
        const firstListItem = ulElement.querySelector('li');
        firstListItem.click();
    };
}
