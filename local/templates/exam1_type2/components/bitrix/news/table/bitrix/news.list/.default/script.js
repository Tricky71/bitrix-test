document.addEventListener('DOMContentLoaded', function() {
    
    // Перехватываем клик на кнопку "Показать еще"
    document.addEventListener('click', function(e) {
        // Проверяем, что кликнули именно по нашей ссылке/кнопке
        if (!e.target.classList.contains('btn-show-more')) return;

        const button = e.target;
        button.innerText = 'Загрузка...';
        button.style.pointerEvents = 'none'; // Защита от повторного клика

        // Находим контейнер с текущими элементами
        const container = document.querySelector('.ajax-items-container');
        if (!container) return;

        // Клонируем и сохраняем текущие элементы (страницу 1), чтобы Битрикс их не стер
        const oldItems = Array.from(container.children);

        // Вешаем одноразовый обработчик на событие успешного AJAX-ответа Битрикса
        BX.addCustomEvent('onAjaxSuccess', function restoreElements() {
            
            // Сразу находим НОВЫЙ контейнер, который прислал Битрикс (там сейчас только страница 2)
            const newContainer = document.querySelector('.ajax-items-container');
            
            if (newContainer) {
                // Берем новые элементы из ответа
                const newItems = Array.from(newContainer.children);
                
                // Очищаем контейнер
                newContainer.innerHTML = '';
                
                // Вставляем обратно старые элементы (страница 1)
                oldItems.forEach(item => newContainer.appendChild(item));
                
                // Дописываем вниз новые элементы (страница 2)
                newItems.forEach(item => newContainer.appendChild(item));
            }

            // Удаляем этот кастомный обработчик, чтобы он не срабатывал на другие AJAX-запросы
            BX.removeCustomEvent('onAjaxSuccess', restoreElements);
        });
    });
});