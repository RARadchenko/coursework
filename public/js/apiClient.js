/**
 * Виконує асинхронний POST-запит до API.
 * @param {string} endpoint - Шлях до API-ендпоінту 
 * @param {object} data - Об'єкт даних для відправки 
 * @returns {Promise<object>} - Promise, що вирішується даними JSON.
 * @throws {Error}
 */
async function postApi(endpoint, data) {
    try {
        const res = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
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

        const json = await res.json();
        return json;
        
    } catch (error) {
        throw error;
    }
}