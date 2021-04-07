var Ggrach = {};

Ggrach.Utils = {};


Ggrach.DebugBar = {

    initHotKeys: function () {
        // Закрываем панель при нажатии на esc
        window.addEventListener('keydown', Ggrach.Handlers.onKeyEsc, true);
    },

    hasDebugBar: function () {
        return document.querySelector('.ggrach__debug_bar') !== null;
    },

    init: function () {

        document.addEventListener('DOMContentLoaded', function () {
            if (Ggrach.Utils.User.isAdmin() && Ggrach.DebugBar.hasDebugBar())
            {
                if (Ggrach.Utils.Screen.isMobile())
                {
                    Ggrach.DebugBar.removeBar();
                } else
                {
                    Ggrach.DebugBar.initHotKeys();

                    // Закрываем панель при нажатии на область затемнения
                    Ggrach.Utils.DOM.getOverlay().addEventListener('click', function () {
                        document.querySelector('[data-type-notice].active').click();
                    });

                    if (Ggrach.Utils.DOM.getButtonsNotice())
                    {
                        Ggrach.Utils.DOM.getButtonsNotice().forEach(function (element) {
                            element.addEventListener('click', Ggrach.Handlers.onClickItemNotice);
                        });
                    }
                    
                    
                    document.querySelector('[data-click="toggle_debug_bar"]').addEventListener('click', function (e) {
                        e.preventDefault();
                        Ggrach.DebugBar.toggle();
                    });
                }
            }
        });
    },

    removeBar: function () {
        this.getDebugBar().remove();
    },

    getDebugBar: function () {
        return document.querySelector('.ggrach__debug_bar');
    },

    toggle: function () {
        this.getDebugBar().classList.toggle('hide-debug-bar');
    },

    hide: function () {
        this.getDebugBar().classList.add('hide-debug-bar');
    },

    show: function () {
        this.getDebugBar().classList.remove('hide-debug-bar');
    }
};

Ggrach.Utils.Screen = {
    isMobile: function () {
        return window.matchMedia("(max-width: 1100px)").matches;
    }
};

Ggrach.Utils.User = {
    isAdmin: function () {
        return document.getElementById('bx-panel-admin-tab');
    }
};

Ggrach.Utils.DOM = {

    hideOverlay: function () {
        Ggrach.Utils.DOM.getOverlay().style.display = 'none';
        document.querySelector('body').style.overflow = null;
    },

    showOverlay: function () {
        Ggrach.Utils.DOM.getOverlay().style.display = 'block';
        document.querySelector('body').style.overflow = 'hidden';
    },

    getDebugBarLogsType: function (type) {
        return document.querySelector('.ggrach__debug_bar__log[data-type-notice="' + type + '"]');
    },

    getDebugBarLogs: function () {
        return document.querySelectorAll('.ggrach__debug_bar__log');
    },

    getButtonsNotice: function () {
        return document.querySelectorAll('[data-click="show_notice_panel"]');
    },

    getOverlay: function () {
        return document.querySelector('.ggrach__overlay');
    }
};

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

Ggrach.DebugBar.init();
