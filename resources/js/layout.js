/*
Template Name: Minton - Admin & Dashboard Template
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Layouts Js File
*/


/**
 * LeftSidebar
 * @param {*} $ 
 */
!function ($) {
    'use strict';

    class LeftSidebar {
        constructor() {
            this.body = $('body'),
                this.window = $(window);
        }
        /**
             * Reset the theme
             */
        _reset() {
            this.body.removeAttr('data-sidebar-size');
        }
        /**
             * Changes the size of sidebar
             * @param {*} size
             */
        changeSize(size) {
            this.body.attr('data-sidebar-size', size);
            this.parent.updateConfig("sidebar", { "size": size });
        }
        /**
             * Initilizes the menu
             */
        initMenu() {
            var self = this;

            var layout = $.LayoutThemeApp.getConfig();
            var sidebar = $.extend({}, layout ? layout.sidebar : {});
            var defaultSidebarSize = sidebar.size ? sidebar.size : 'condensed';

            // resets everything
            this._reset();

            // Left menu collapse
            $('.button-menu-mobile').on('click', function (event) {
                event.preventDefault();
                var sidebarSize = self.body.attr('data-sidebar-size');
                if (self.window.width() >= 993) {
                    if (sidebarSize === 'condensed') {
                        self.changeSize(defaultSidebarSize === 'condensed' ? 'default' : defaultSidebarSize);
                    } else {
                        self.changeSize('condensed');
                    }
                } else {
                    self.changeSize(defaultSidebarSize);
                    self.body.toggleClass('sidebar-enable');
                }
            });

            // sidebar - main menu
            if ($("#side-menu").length) {
                var navCollapse = $('#side-menu li .collapse');
                var navToggle = $("#side-menu [data-bs-toggle='collapse']");
                navToggle.on('click', function (e) {
                    return false;
                });
                // open one menu at a time only
                navCollapse.on({
                    'show.bs.collapse': function (event) {
                        $('#side-menu .collapse.show').not(parent).collapse('hide');
                        var parent = $(event.target).parents('.collapse.show');
                    },
                });


                // activate the menu in left side bar (Vertical Menu) based on url
                $("#side-menu a").each(function () {
                    var pageUrl = window.location.href.split(/[?#]/)[0];
                    if (this.href == pageUrl) {
                        $(this).addClass("active");
                        $(this).parent().addClass("menuitem-active");
                        $(this).parent().parent().parent().addClass("show");
                        $(this).parent().parent().parent().parent().addClass("menuitem-active"); // add active to li of the current link

                        var firstLevelParent = $(this).parent().parent().parent().parent().parent().parent();
                        if (firstLevelParent.attr('id') !== 'sidebar-menu')
                            firstLevelParent.addClass("show");

                        $(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active");

                        var secondLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (secondLevelParent.attr('id') !== 'wrapper')
                            secondLevelParent.addClass("show");

                        var upperLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (!upperLevelParent.is('body'))
                            upperLevelParent.addClass("menuitem-active");
                    }
                });
            }
          
        }
        /**
             * Initilize the left sidebar size based on screen size
             */
        initLayout() {
            var self = this;
            // in case of small size, activate the small menu
            if ((this.window.width() >= 768 && this.window.width() <= 1028) || this.body.data('keep-enlarged')) {
                this.changeSize('condensed');
            } else {
                var layout = JSON.parse(this.body.attr('data-layout') ? this.body.attr('data-layout') : '{}');
                var sidebar = $.extend({}, layout ? layout.sidebar : {});
                var defaultSidebarSize = sidebar && sidebar.size ? sidebar.size : 'condensed';
                var sidebarSize = self.body.attr('data-sidebar-size');
                this.changeSize(defaultSidebarSize ? defaultSidebarSize : (sidebarSize ? sidebarSize : 'default'));
            }
        }
        /**
             * Initilizes the menu
             */
        init() {
            var self = this;
            this.initMenu();
            this.initLayout();

            // on window resize, make menu flipped automatically
            this.window.on('resize', function (e) {
                e.preventDefault();
                self.initLayout();
            });
        }
    }

    $.LeftSidebar = new LeftSidebar, $.LeftSidebar.Constructor = LeftSidebar
}(window.jQuery),


/**
 * Topbar
 * @param {*} $ 
 */
function ($) {
    'use strict';

    class Topbar {
        constructor() {
            this.body = $('body'),
                this.window = $(window);
        }
        /**
             * Initilizes the menu
             */
        initMenu() {
            // Serach Toggle
            $('#top-search').on('click', function (e) {
                $('#search-dropdown').addClass('d-block');
            });

            // hide search on opening other dropdown
            $('.topbar-dropdown').on('show.bs.dropdown', function () {
                $('#search-dropdown').removeClass('d-block');
            });

            //activate the menu in topbar(horizontal menu) based on url
            $(".navbar-nav a").each(function () {
                var pageUrl = window.location.href.split(/[?#]/)[0];
                if (this.href == pageUrl) {
                    $(this).addClass("active");
                    $(this).parent().addClass("active");
                    $(this).parent().parent().addClass("active");
                    $(this).parent().parent().parent().addClass("active");
                    $(this).parent().parent().parent().parent().addClass("active");
                    var el = $(this).parent().parent().parent().parent().addClass("active").prev();
                    if (el.hasClass("nav-link"))
                        el.addClass('active');
                }
            });

            // Topbar - main menu
            $('.navbar-toggle').on('click', function (event) {
                $(this).toggleClass('open');
                $('#navigation').slideToggle(400);
            });
        }
        
        /**
             * Initilizes the menu
             */
        init() {
            this.initMenu();
        }
    }
    $.Topbar = new Topbar, $.Topbar.Constructor = Topbar
}(window.jQuery),


/**
 * Layout and theme manager
 * @param {*} $ 
 */

function ($) {
    'use strict';

    // Layout and theme manager

    class LayoutThemeApp {
        constructor() {
            this.body = $('body'),
                this.window = $(window),
                this.config = {},
                // styles
                this.defaultBSStyle = $("#bs-default-stylesheet"),
                this.defaultAppStyle = $("#app-default-stylesheet"),
                this.darkBSStyle = $("#bs-dark-stylesheet"),
                this.darkAppStyle = $("#app-dark-stylesheet");
        }
        /**
            * Preserves the config in memory
            */
        _saveConfig(newConfig) {
            this.config = $.extend(this.config, newConfig);
            // NOTE: You can make ajax call here to save preference on server side or localstorage as well
        }
        /**
             * Update the config for given config
             * @param {*} param
             * @param {*} config
             */
        updateConfig(param, config) {
            var newObj = {};


            if (typeof config === 'object' && config !== null) {
                var originalParam = this.config[param];
                newObj[param] = $.extend(originalParam, config);
            } else {
                newObj[param] = config;
            }
            this._saveConfig(newObj);

        }
        /**
             * Loads the config - takes from body if available else uses default one
             */
        loadConfig() {
            var bodyConfig = JSON.parse(this.body.attr('data-layout') ? this.body.attr('data-layout') : '{}');

            var config = $.extend({}, {
                mode: "light",
                width: "fluid",
                menuPosition: 'fixed',
                sidebar: {
                    color: "light",
                    size: "condensed",
                    showuser: false
                },
                topbar: {
                    color: "dark"
                },
                showRightSidebarOnPageLoad: false
            });
            if (bodyConfig) {
                config = $.extend({}, config, bodyConfig);
            };
            return config;
        }
        /**
            * Apply the config
            */
        applyConfig() {
            // getting the saved config if available
            this.config = this.loadConfig();
            var topbarConfig = $.extend({}, this.config.topbar);

            // activate menus
            this.leftSidebar.init();
            this.topbar.init();

            this.leftSidebar.parent = this;
            this.topbar.parent = this;

        }
     
        /**
             * Clear out the saved config
             */
        clearSavedConfig() {
            this.config = {};
        }
        /**
             * Gets the config
             */
        getConfig() {
            return this.config;
        }
        /**
             * Reset to default
             */
        reset() {
            this.clearSavedConfig();
            this.applyConfig();
        }
        /**
             * Init
             */
        init() {
            this.leftSidebar = $.LeftSidebar;
            this.topbar = $.Topbar;

            this.leftSidebar.parent = this;
            this.topbar.parent = this;

            // initilize the menu
            this.applyConfig();
        }
    }
    $.LayoutThemeApp = new LayoutThemeApp, $.LayoutThemeApp.Constructor = LayoutThemeApp
}(window.jQuery);