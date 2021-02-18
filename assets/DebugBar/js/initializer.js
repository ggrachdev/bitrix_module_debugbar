var Ggrach = {
    DebugBar: {
        init: function () {
            document.addEventListener('DOMContentLoaded', function () {
                if (Ggrach.Utils.User.isAdmin())
                {
                    var parent = document.querySelector("body");
                    var debugBarWrapper = document.createElement("section");
                    debugBarWrapper.classList.add('ggrach__debug_bar');

                    parent.prepend(debugBarWrapper);

                    for (var typeNotice in GgrachDebuggerLogProvider)
                    {
                        var arrNotices = GgrachDebuggerLogProvider[typeNotice];
                        var viewTypeNotice = document.createElement("div");
                        viewTypeNotice.classList.add('ggrach__debug_bar__item');
                        viewTypeNotice.classList.add('type-notice-' + typeNotice);
                        viewTypeNotice.innerHTML = arrNotices.length;
                        debugBarWrapper.prepend(viewTypeNotice);
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
