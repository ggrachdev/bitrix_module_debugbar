Ggrach.Utils.DOM = {
    
    hideAllScreenLogs: function() {
        var $activeDebugItem = document.querySelector('.ggrach__debug-bar__item.active');

        if($activeDebugItem)
        {
            $activeDebugItem.click();
        }
    },

    hideOverlay: function () {
        Ggrach.Utils.DOM.getOverlay().style.display = 'none';
        document.querySelector('body').style.overflow = null;
        document.querySelector('html').style.overflow = null;
    },

    showOverlay: function () {
        Ggrach.Utils.DOM.getOverlay().style.display = 'block';
        document.querySelector('body').setAttribute('style', 'overflow: hidden !important');
        document.querySelector('html').setAttribute('style', 'overflow: hidden !important');
    },

    getDebugBarLogsType: function (type) {
        return document.querySelector('.ggrach__debug-bar__log[data-type-notice="' + type + '"]');
    },

    getDebugBarLogs: function () {
        return document.querySelectorAll('.ggrach__debug-bar__log');
    },

    getButtonsNotice: function () {
        return document.querySelectorAll('[data-click="show_notice_panel"]');
    },

    getOverlay: function () {
        return document.querySelector('.ggrach__overlay');
    }
};