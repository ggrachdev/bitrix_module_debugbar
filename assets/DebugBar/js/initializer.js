var Ggrach = {
    DebugBar: {
        init: function () {
            document.addEventListener('DOMContentLoaded', function () {
                if (Ggrach.Utils.User.isAdmin())
                {
                    if (Ggrach.Utils.Screen.isMobile())
                    {
                        document.querySelector('.ggrach__debug_bar').remove();
                    } else
                    {
                        var $logsItems = document.querySelectorAll('[data-click="show_notice_panel"]');

                        if ($logsItems)
                        {
                            $logsItems.forEach(function (element) {
                                element.addEventListener('click', function (e) {
                                    var type = e.target.dataset.typeNotice;

                                    document.querySelectorAll('.ggrach__debug_bar__log').forEach(function (element) {

                                        element.scrollTop = 0;

                                        if (element.dataset.typeNotice !== type)
                                        {
                                            element.style.display = 'none';
                                        }

                                    });

                                    var $targetLogPanel = document.querySelector('.ggrach__debug_bar__log[data-type-notice="' + type + '"]');

                                    $logsItems.forEach(function (el) {
                                        el.classList.remove('active');
                                    });

                                    if ($targetLogPanel.style.display === 'block')
                                    {
                                        e.target.classList.remove('active');
                                        document.querySelector('body').style.overflow = null;
                                        $targetLogPanel.style.display = 'none';
                                        document.querySelector('.ggrach__overlay').style.display = 'none';
                                    } else
                                    {
                                        e.target.classList.add('active');
                                        document.querySelector('body').style.overflow = 'hidden';
                                        $targetLogPanel.style.display = 'block';
                                        document.querySelector('.ggrach__overlay').style.display = 'block';
                                    }
                                });
                            });
                        }
                    }
                }
            });
        }
    }
};

Ggrach.Utils = {
    User: {
        isAdmin: function () {
            return document.getElementById('panel') &&
                document.getElementById('bx-panel-admin-tab');
        }
    },

    Screen: {
        isMobile: function () {
            return window.matchMedia("(max-width: 1100px)").matches;
        }
    }
};

Ggrach.DebugBar.init();
