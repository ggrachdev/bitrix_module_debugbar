var Ggrach = {
    DebugBar: {
        init: function () {
            document.addEventListener('DOMContentLoaded', function () {
                if (Ggrach.Utils.User.isAdmin())
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

                                if ($targetLogPanel.style.display === 'block')
                                {
                                    
                                    document.querySelector('body').style.overflow = null;
                                    $targetLogPanel.style.display = 'none';
                                } else
                                {
                                    document.querySelector('body').style.overflow = 'hidden';
                                    $targetLogPanel.style.display = 'block';
                                }
                            });
                        });
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
    }
};

Ggrach.DebugBar.init();
