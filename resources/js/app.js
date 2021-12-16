/*
Template Name: Minton - Admin & Dashboard Template
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Main Js File
*/


!function ($) {
    "use strict";

    class Components {
        constructor() { }
        //initializing tooltip
        initTooltipPlugin() {
            $.fn.tooltip && $('[data-bs-toggle="tooltip"]').tooltip();
        }
        //initializing popover
        initPopoverPlugin() {
            $.fn.popover && $('[data-bs-toggle="popover"]').popover();
        }
        //initializing toast
        initToastPlugin() {
            $.fn.toast && $('[data-bs-toggle="toast"]').toast();
        }
        //initializing form validation
        initFormValidation() {
            $(".needs-validation").on('submit', function (event) {
                $(this).addClass('was-validated');
                if ($(this)[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
                return true;
            });
        }
        // Counterup
        initCounterUp() {
            var delay = $(this).attr('data-delay') ? $(this).attr('data-delay') : 100; //default is 100
            var time = $(this).attr('data-time') ? $(this).attr('data-time') : 1200; //default is 1200
            $('[data-plugin="counterup"]').each(function (idx, obj) {
                $(this).counterUp({
                    delay: delay,
                    time: time
                });
            });
        }
        //peity charts
        initPeityCharts() {
            $('[data-plugin="peity-pie"]').each(function (idx, obj) {
                var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
                var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20
                var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20
                $(this).peity("pie", {
                    fill: colors,
                    width: width,
                    height: height
                });
            });
            //donut
            $('[data-plugin="peity-donut"]').each(function (idx, obj) {
                var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
                var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20
                var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20
                $(this).peity("donut", {
                    fill: colors,
                    width: width,
                    height: height
                });
            });

            $('[data-plugin="peity-donut-alt"]').each(function (idx, obj) {
                $(this).peity("donut");
            });

            // line
            $('[data-plugin="peity-line"]').each(function (idx, obj) {
                $(this).peity("line", $(this).data());
            });

            // bar
            $('[data-plugin="peity-bar"]').each(function (idx, obj) {
                var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
                var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20
                var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20
                $(this).peity("bar", {
                    fill: colors,
                    width: width,
                    height: height
                });
            });
        }
        initKnob() {
            $('[data-plugin="knob"]').each(function (idx, obj) {
                $(this).knob();
            });
        }
        initTippyTooltips() {
            if ($('[data-plugin="tippy"]').length > 0)
                tippy('[data-plugin="tippy"]');
        }
        
        initShowPassword() {
            $("[data-password]").on('click', function () {
                if ($(this).attr('data-password') == "false") {
                    $(this).siblings("input").attr("type", "text");
                    $(this).attr('data-password', 'true');
                    $(this).addClass("show-password");
                } else {
                    $(this).siblings("input").attr("type", "password");
                    $(this).attr('data-password', 'false');
                    $(this).removeClass("show-password");
                }
            });
        }
        initMultiDropdown() {
            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                return false;
            });
        }

        initJS(){
            $('.currency').inputmask({ 'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0.00'});

            $('[data-plugin="switchery"]').each(function (idx, obj) {
                new Switchery($(this)[0], $(this).data());
            });
            
            $('.select2').select2();
            $('.year').datepicker({
                minViewMode: 2,
                format: 'yyyy',
            });
            $(document).on('click', "form.delete button", function(e) {
                var _this = $(this);
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi', // Opération Dangereuse
                    text: 'Apakah anda yakin untuk menghapus Data?', // Êtes-vous sûr de continuer ?
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonColor: 'null',
                    cancelButtonColor: 'null',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-primary',
                    confirmButtonText: 'Ya, hapus!', // Oui, sûr
                    cancelButtonText: 'Batal', // Annuler
                }).then(res => {
                    if (res.value) {
                        _this.closest("form").submit();
                    }
                });
            });

            $(document).on('click', "#btn-submit", function(e) {
                var _this = $(this);
                var form = _this.parents('form');

                form.validate({
                    onfocusout: false,
                    invalidHandler: function(form, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            validator.errorList[0].element.focus();
                        }
                    }
                });

                e.preventDefault();
                if (form.valid()) {
                    Swal.fire({
                        title: 'Konfirmasi', // Opération Dangereuse
                        text: 'Apakah anda yakin melanjutkan ini?', // Êtes-vous sûr de continuer ?
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: 'null',
                        cancelButtonColor: 'null',
                        confirmButtonClass: 'btn btn-danger',
                        cancelButtonClass: 'btn btn-primary',
                        confirmButtonText: 'Ya, lanjut', // Oui, sûr
                        cancelButtonText: 'Batal', // Annuler
                    }).then(res => {
                        if (res.value) {
                            _this.closest("form").submit();
                        }
                    });
                }
            });
        }

        //initilizing
        init() {
            this.initTooltipPlugin(),
            this.initPopoverPlugin(),
            this.initToastPlugin(),
            this.initFormValidation(),
            this.initCounterUp(),
            this.initPeityCharts(),
            this.initKnob();
            this.initTippyTooltips();
            this.initShowPassword();
            this.initMultiDropdown();
            this.initJS();
        }
    }

    $.Components = new Components, 
    $.Components.Constructor = Components

}(window.jQuery),

function($) {
    "use strict";

    /**
    Portlet Widget
    */
    class Portlet {
        constructor() {
            this.$body = $("body"),
                this.$portletIdentifier = ".card",
                this.$portletCloser = '.card a[data-toggle="remove"]',
                this.$portletRefresher = '.card a[data-toggle="reload"]';
        }
        //on init
        init() {
            // Panel closest
            var $this = this;
            $(document).on("click", this.$portletCloser, function (ev) {
                ev.preventDefault();
                var $portlet = $(this).closest($this.$portletIdentifier);
                var $portlet_parent = $portlet.parent();
                $portlet.remove();
                if ($portlet_parent.children().length == 0) {
                    $portlet_parent.remove();
                }
            });

            // Panel Reload
            $(document).on("click", this.$portletRefresher, function (ev) {
                ev.preventDefault();
                var $portlet = $(this).closest($this.$portletIdentifier);
                // This is just a simulation, nothing is going to be reloaded
                $portlet.append('<div class="card-disabled"><div class="card-portlets-loader"><div class="spinner-border text-primary m-2" role="status"></div></div></div>');
                var $pd = $portlet.find('.card-disabled');
                setTimeout(function () {
                    $pd.fadeOut('fast', function () {
                        $pd.remove();
                    });
                }, 500 + 300 * (Math.random() * 5));
            });
        }
    }

    //
    $.Portlet = new Portlet, $.Portlet.Constructor = Portlet
    
}(window.jQuery),


function ($) {
    'use strict';

    class App {
        constructor() {
            this.$body = $('body'),
                this.$window = $(window);
        }
        /**
             * Initlizes the controls
            */
        initControls() {
            // remove loading
            setTimeout(function () {
                document.body.classList.remove('loading');
            }, 400);

            // Preloader
            $(window).on('load', function () {
                $('#status').fadeOut();
                $('#preloader').delay(350).fadeOut('slow');
            });

            $('[data-toggle="fullscreen"]').on("click", function (e) {
                e.preventDefault();
                $('body').toggleClass('fullscreen-enable');
                if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    }
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            });
            document.addEventListener('fullscreenchange', exitHandler);
            document.addEventListener("webkitfullscreenchange", exitHandler);
            document.addEventListener("mozfullscreenchange", exitHandler);
            function exitHandler() {
                if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                    console.log('pressed');
                    $('body').removeClass('fullscreen-enable');
                }
            }
        }
        //initilizing
        init() {
            $.Portlet.init();
            $.Components.init();

            this.initControls();

            // init layout
            this.layout = $.LayoutThemeApp;
            this.layout.init();


            //Popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            //Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {});
            });



            //Toasts
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });

            // Toasts Placement
            var toastPlacement = document.getElementById("toastPlacement");
            if (toastPlacement) {
                document.getElementById("selectToastPlacement").addEventListener("change", function () {
                    if (!toastPlacement.dataset.originalClass) {
                        toastPlacement.dataset.originalClass = toastPlacement.className;
                    }
                    toastPlacement.className = toastPlacement.dataset.originalClass + " " + this.value;
                });
            }
       
        }
    }


    $.App = new App, $.App.Constructor = App


}(window.jQuery),
//initializing main application module
function ($) {
    "use strict";
    $.App.init();
}(window.jQuery);

// Waves Effect
Waves.init();
