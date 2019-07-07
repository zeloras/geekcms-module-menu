var moduleMenuAdmin = {
    config: {
        'menu_block': '.menu_admin',
        'menu_lists': '.menu_main_list',
        'menu_data': '.menu_admin_sort_data',
        'menu_type': '.menu_admin_type',
        'menu_item_action': '.menu_item_action',
        'delete_menu': '.delete-all',
        'main_config': {
            link: {
                off: '#iActionPage, #iActionAnhor, #iActionRoute', on: '#iActionLink', require: true,
            },
            anhor: {
                off: '#iActionLink, #iActionPage, #iActionRoute', on: '#iActionAnhor', require: true,
            },
            page: {
                off: '#iActionAnhor, #iActionLink, #iActionRoute', on: '#iActionPage', require: true,
            },
            route: {
                off: '#iActionAnhor, #iActionLink, #iActionPage', on: '#iActionRoute', require: true,
            }
        },
        'route_config': {
            route: {elem: '#iActionRoute', prefix: '', bind: 'change'},
            page: {elem: '#iActionPage', prefix: '', bind: 'change'},
            anhor: {elem: '#iActionAnhor', prefix: 'anhor::', bind: 'keyup'},
            link: {elem: '#iActionLink', prefix: 'link::', bind: 'keyup'},
        }
    },

    init: function () {
        let self = this;
        let config = self.config;

        /**
         * Call plugin for drag & drop menu items
         */
        $(config.menu_block).nestable({});

        /**
         * Call after changed menu position
         */
        $(config.menu_block).unbind('change').on('change', function (e) {
            self.changeMenuPosition(e);
        });

        /**
         * Delete selected menu
         */
        $(config.delete_menu).unbind('click').on('click', function () {
            adminMainComponent.deleteMassive(this);
        });

        /**
         * Redirect to another selected menu
         */
        $(config.menu_lists).unbind('change').on('change', function (e) {
            document.location.href = menuIndexUrl + '/' + $(this).val();
        });

        adminMainComponent.toggleFormGroup($(config.menu_type), config.main_config, 'moduleMenuAdmin.mainCallbackMenu');
        $(config.menu_type).unbind('change').on('change', function () {
            adminMainComponent.toggleFormGroup(this, config.main_config, 'moduleMenuAdmin.mainCallbackMenu');
        });
    },

    /**
     * Drag & drop change menu position
     *
     * @param elem
     */
    changeMenuPosition: function (elem) {
        let self = this;
        let config = self.config;
        let item = elem.length ? $(elem) : $(elem.target);

        if (item.length) {
            $(config.menu_data).val(window.JSON.stringify(item.nestable('serialize')))
        }
    },

    /**
     * Callback function call after some changes in field by page type
     *
     * @param elem
     * @param name
     */
    mainCallbackMenu: function (elem, name) {
        let self = moduleMenuAdmin;
        let config = self.config;
        let action = $(config.menu_item_action);
        let help = $('#actionTypeHelp');
        let route_config = config.route_config;

        for (let conf in route_config) {
            if (name === conf) {
                let element = $(route_config[conf]['elem']);
                self.setData(action, help, route_config[conf]['prefix'] + element.val());
                element.unbind(route_config[conf]['bind']).on(route_config[conf]['bind'], function () {
                    self.setData(action, help, route_config[conf]['prefix'] + $(this).val());
                });
            }
        }
    },

    /**
     * Set data for serialized field and e.g block
     *
     * @param action
     * @param help
     * @param data
     */
    setData: function (action, help, data){
        action.val(data);
        help.html(data);
    }
};

$(document).on('mainComponentsAdminLoaded', function () {
    moduleMenuAdmin.init();
});