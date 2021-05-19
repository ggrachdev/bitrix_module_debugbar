Ggrach.DebugBar = {

    initHotKeys: function () {
        // Закрываем панель при нажатии на esc
        window.addEventListener('keydown', Ggrach.Handlers.onKeyEsc, true);
    },

    hasDebugBar: function () {
        return document.querySelector('.ggrach__debug-bar') !== null;
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
        return document.querySelector('.ggrach__debug-bar');
    },

    toggle: function () {
        if(this.getDebugBar().classList.contains('hide-debug-bar'))
        {
            BX.setCookie('ggrach_debug_bar_is_close', 'false', {expires: (60 * 60 * 2), path: '/'});
        }
        else
        {
            Ggrach.Utils.DOM.hideAllScreenLogs();
            BX.setCookie('ggrach_debug_bar_is_close', 'true', {expires: (60 * 60 * 2), path: '/'});
        }
        
        this.getDebugBar().classList.toggle('hide-debug-bar');
    },

    hide: function () {
        this.getDebugBar().classList.add('hide-debug-bar');
        BX.setCookie('ggrach_debug_bar_is_close', 'true', {expires: (60 * 60 * 2), path: '/'});
    },

    show: function () {
        this.getDebugBar().classList.remove('hide-debug-bar');
        BX.setCookie('ggrach_debug_bar_is_close', 'false', {expires: (60 * 60 * 2), path: '/'});
    }
};
