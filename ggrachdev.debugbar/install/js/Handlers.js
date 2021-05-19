Ggrach.Handlers = {

    // Нажатие клавиши esc
    onKeyEsc: function (e) {
        if ((e.key === 'Escape' || e.key === 'Esc' || e.keyCode == 27) && (e.target.nodeName === 'BODY')) {

            if (document.querySelector('[data-type-notice].active'))
            {
                document.querySelector('[data-type-notice].active').click();
            }
        }
    },

    onClickItemNotice: function (e) {
        var type = e.target.dataset.typeNotice;

        Ggrach.Utils.DOM.getDebugBarLogs().forEach(function (element) {

            element.scrollTop = 0;

            if (element.dataset.typeNotice !== type)
            {
                element.style.display = 'none';
            }

        });

        var $targetLogPanel = Ggrach.Utils.DOM.getDebugBarLogsType(type);

        Ggrach.Utils.DOM.getButtonsNotice().forEach(function (el) {
            el.classList.remove('active');
        });

        if ($targetLogPanel.style.display === 'block')
        {
            e.target.classList.remove('active');
            $targetLogPanel.style.display = 'none';
            Ggrach.Utils.DOM.hideOverlay();
        } else
        {
            e.target.classList.add('active');
            $targetLogPanel.style.display = 'block';
            Ggrach.Utils.DOM.showOverlay();
        }
    }
};