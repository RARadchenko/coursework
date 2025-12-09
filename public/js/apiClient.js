/**
 * Виконує асинхронний POST-запит до API.
 * @param {string} endpoint - Шлях до API-ендпоінту 
 * @param {object} data - Об'єкт даних для відправки 
 * @returns {Promise<object>} - Promise, що вирішується даними JSON.
 * @throws {Error}
 */
async function postApi(endpoint, data) {
    try {
        const isFormData = data instanceof FormData;

        const res = await fetch(endpoint, {
            method: 'POST',
            headers: isFormData ? {} : { 'Content-Type': 'application/json' },
            body: isFormData ? data : JSON.stringify(data)
        });

        if (!res.ok) {
            let errorDetails = '';
            try {
                const errorJson = await res.json();
                errorDetails = errorJson.error || JSON.stringify(errorJson);
            } catch (e) {
                errorDetails = res.statusText || 'Невідома помилка';
            }
            throw new Error(`Помилка HTTP: ${res.status}. Деталі: ${errorDetails}`);
        }

        // Якщо сервер повертає JSON — читаємо JSON
        // Якщо сервер при FormData повертає не JSON — не буде помилки
        try {
            return await res.json();
        } catch {
            return res;
        }

    } catch (error) {
        throw error;
    }
}
