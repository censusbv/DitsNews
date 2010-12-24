var dnPageGroups = Ext.extend(Ext.Panel, {
	initComponent: function() {

        this.rowMenu = new Ext.menu.Menu({
            baseParams: {
                rowId: null,
                node: null
            },
            items: [
                {
                    text: _('ditsnews.groups.remove'),
                    scope: this,
                    handler: function() {
                        Ext.Msg.show({
                            title: _('ditsnews.groups.remove.title'),
                            msg: _('ditsnews.groups.remove.confirm'),
                            buttons: Ext.Msg.YESNO,
                            scope: this,
                            fn: function(response) {
                                if (response == 'yes') {
                                    var groupId = this.rowMenu.baseParams.rowId;
                                    
                                    dnCore.ajax.request({
                                        url: dnCore.config.connectorUrl,
                                        params: {
                                            action: 'mgr/groups/remove',
                                            groupId: groupId
                                        },
                                        scope: this,
                                        success: function(response) {
                                            this.groupGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                                        }
                                    });
                                }
                            }
                        });
                    }
                },
                {
                    text: _('ditsnews.groups.update'),
                    scope: this,
                    handler: function() {
                        dnCore.ajax.request({
                            url: dnCore.config.connectorUrl,
                            params: {
                                id: this.rowMenu.baseParams.rowId,
                                action: 'mgr/groups/get'
                            },
                            scope: this,
                            success: function(response) {
                                var groupConfig = Ext.decode(response.responseText);
                                groupConfig = groupConfig.object;

                                // Set form values
                                this.newGroupForm.getForm().setValues(groupConfig);
                                this.newGroupWindow.setTitle( _('ditsnews.groups.update'));
                                this.newGroupWindow.show();
                            }
                        });
                    }
                }

            ]
        });


		this.newGroupForm = new Ext.form.FormPanel({
			border: false,
			labelWidth: 150,
			monitorValid: true,
			buttons: [
				{
					text: _('cancel'),
					scope: this,
					handler: function() {
						this.newGroupWindow.hide();
					}
				},
				{
					text: _('save'),
					formBind: true,
					scope: this,
					handler: function() {
						var postData = {
							formData: Ext.encode(this.newGroupForm.getForm().getFieldValues()),
							action: 'mgr/groups/save'
						}

						dnCore.ajax.request({
							url: dnCore.config.connectorUrl,
							params: postData,
							scope: this,
							success: function() {
                                this.groupGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
								this.newGroupWindow.hide();
                                dnCore.showMessage(_('ditsnews.groups.saved'));
							}
						});
					}
				}
			],
			items: [
				{
                    layout: 'form',
                    id: 'new-group-form',
                    items: [
                        {
                            xtype: 'hidden',
                            name: 'id',
                            id: 'group-id'
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.groups.name'),
                            name: 'name',
                            allowBlank: false
                        },
                        {
                            xtype: 'checkbox',
                            name: 'public',
                            fieldLabel: _('ditsnews.groups.public.desc'),
                            inputValue: true,
                            checked: false
                        }
                    ]
                }
			]
		});

		this.newGroupWindow = new Ext.Window({
			padding: 10,
			title: _('ditsnews.groups.new'),
			width: 750,
			y: 20,
			autoHeight: true,
			closeAction: 'hide',
			items: [
				this.newGroupForm
			]
		});


        this.groupGrid = new Ext.grid.GridPanel({
            autoHeight: true,
            loadMask: true,
            viewConfig: {
                forceFit: true,
                enableRowBody: true,
                autoFill: true,
                deferEmptyText: false,
                showPreview: true,
                scrollOffset: 0,
                emptyText: _('ext_emptymsg')
            },
            store: dnCore.stores.groups,
            tbar: [
                {
					xtype: 'button',
					text: _('ditsnews.groups.new'),
					scope: this,
					handler: function() {
						this.newGroupForm.getForm().reset();
                        this.newGroupForm.getForm().setValues({
                            id: 0,
                            name: ''
                        });
						Ext.getCmp('group-id').setValue(0);
                        this.newGroupWindow.setTitle( _('ditsnews.groups.new'));
						this.newGroupWindow.show();
					}
                },
                {xtype: 'tbfill'},
                {
                    text: _('ditsnews.menu'),
                    menu: [dnCore.mainMenu]
                }
            ],
            columns: [
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'id',
                        header: '#',
                        sortable: true,
                        width: 10
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'name',
                        header: _('ditsnews.groups.name'),
                        sortable: true,
                        id: 'group-title'
                    },
                    {
                        xtype: 'checkcolumn',
                        dataIndex: 'public',
                        header: _('ditsnews.groups.public'),
                        width: 10,
                        disabled: true
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'members',
                        header: _('ditsnews.groups.members'),
                        sortable: true,
                        width: 15
                    }
            ],
            autoExpandColumn: 'group-title',
            bbar: new Ext.PagingToolbar({
                pageSize: dnCore.pageSize,
                displayInfo: true,
                emptyMsg: _('no_records_found'),
                store: dnCore.stores.groups
            }),
            listeners: {
                added: {
                    fn: function(grid) {
                        grid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                    }
                },
                rowContextMenu: {
                    scope: this,
                    fn: function(grid, rowIndex, event) {
                        // Set the database ID in the menu's base params so we can access it when an action is performed
                        this.rowMenu.baseParams.rowId = dnCore.stores.groups.getAt(rowIndex).get('id');
                        this.rowMenu.showAt(event.xy);
                        event.stopEvent();
                    }
                }

            }
        });

		// The mainpanel always has to be in the "this.mainPanel" variable
		this.mainPanel = new Ext.Panel({
			renderTo: 'ditsnews-content',
			padding: 15,
			border: true,
			items: [
				this.groupGrid
			]
		});
	}
});

Ext.onReady(function() {
	// Set page title
	dnCore.setTitle(_('ditsnews.groups'));

    // this makes the main class accessible through dnCore.pageClass and the panel through dnCore.pagePanel
    dnCore.loadPanel(dnPageGroups);
});