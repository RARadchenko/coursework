const dropdown = document.querySelector('.dropdown-list');

dropdown.addEventListener('click', (e) => {
    // якщо клік по елементу списку
    if (e.target.closest('ul')) {
        const selected = e.target.textContent.trim();

        // міняємо текст тригера (перший текстовий вузол у li)
        dropdown.childNodes[0].nodeValue = selected + ' ';

        dropdown.classList.remove('show');
        return;
    }

    // клік по самому li → відкриваємо/закриваємо
    dropdown.classList.toggle('show');
});
