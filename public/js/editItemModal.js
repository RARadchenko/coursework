async function openEditProductModal(response, onSubmit) {
    
    const content = response.content;
    const action = 'itemEdit'

    const backdrop = document.createElement('div');
    backdrop.id = 'dynamic-modal-backdrop';

    const modal = document.createElement('div');
    modal.id = 'dynamic-modal';

    const productWrapper = document.createElement('div');
    productWrapper.className = 'modal-field';

    const productLabel = document.createElement('label');
    productLabel.textContent = 'Продукт';

    const productSelect = document.createElement('select');
    productSelect.name = 'product_id';

    const emptyOpt = document.createElement('option');
    emptyOpt.value = '';
    emptyOpt.textContent = 'Оберіть продукт';
    productSelect.appendChild(emptyOpt);

    Object.entries(response['Продукт']).forEach(([id, text]) => {
        const opt = document.createElement('option');
        opt.value = id;
        opt.textContent = text;
        productSelect.appendChild(opt);
    });

    productWrapper.append(productLabel, productSelect);
    modal.appendChild(productWrapper);

    const fieldMap = ['Назва', 'Ціна', 'Категорія', 'Одиниці', 'Правило', 'Відображення'];

    fieldMap.forEach(key => {
        const wrapper = document.createElement('div');
        wrapper.className = 'modal-field';

        const label = document.createElement('label');
        label.textContent = key;

        const placeholder = document.createElement('input');
        placeholder.disabled = true;
        placeholder.name = key;

        wrapper.append(label, placeholder);
        modal.appendChild(wrapper);
    });

    productSelect.onchange = async () => {
        if (!productSelect.value) return;

        try {
            const data = await postApi('/api/changeContent', {
                action: 'getProduct',
                product_id: productSelect.value
            }, false);

            const productData = data.content;

            fieldMap.forEach(key => {
                const wrapper = modal.querySelector(`[name="${key}"]`)?.parentElement;
                if (!wrapper || !productData[key]) return;

                wrapper.innerHTML = '';

                const label = document.createElement('label');
                label.textContent = key;

                let field;

                // SELECT
                if (typeof productData[key] === 'object' && productData[key].options) {
                    field = document.createElement('select');
                    field.name = key;

                    Object.entries(productData[key].options).forEach(([id, text], index) => {
                        const opt = document.createElement('option');
                        opt.value = id;
                        opt.textContent = text;

                        if (
                            productData[key].selected == id ||
                            productData[key].selected == index
                        ) {
                            opt.selected = true;
                        }

                        field.appendChild(opt);
                    });
                }
                else {
                    field = document.createElement('input');
                    field.type = 'text';
                    field.name = key;
                    field.value = productData[key];
                }

                wrapper.append(label, field);
            });

        } catch (e) {
            console.error('Помилка завантаження продукту', e);
        }
    };


    const btnOk = document.createElement('button');
    btnOk.textContent = 'OK';

    const btnCancel = document.createElement('button');
    btnCancel.textContent = 'Скасувати';

    modal.append(btnOk, btnCancel);
    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);

    btnOk.onclick = async () => {
        const payload = {
            product_id: productSelect.value
        };

        modal.querySelectorAll('input, select').forEach(el => {
            if (el.name) payload[el.name] = el.value;
        });

        try {
            await postApi('/api/' + action, payload, false);
            onSubmit(payload);
        } catch (e) {
            console.error(e);
        }

        backdrop.remove();
    };

    btnCancel.onclick = () => backdrop.remove();
}
