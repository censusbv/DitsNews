var dnPageSubscribers = Ext.extend(Ext.Panel, {
	initComponent: function() {

        this.rowMenu = new Ext.menu.Menu({
            baseParams: {
                rowId: null,
                node: null
            },
            items: [
                {
                    text: _('ditsnews.subscribers.remove'),
                    scope: this,
                    handler: function() {
                        Ext.Msg.show({
                            title: _('ditsnews.subscribers.remove.title'),
                            msg: _('ditsnews.subscribers.remove.confirm'),
                            buttons: Ext.Msg.YESNO,
                            scope: this,
                            fn: function(response) {
                                if (response == 'yes') {
                                    var subscriberId = this.rowMenu.baseParams.rowId;
                                    
                                    dnCore.ajax.request({
                                        url: dnCore.config.connectorUrl,
                                        params: {
                                            action: 'mgr/subscribers/remove',
                                            subscriberId: subscriberId
                                        },
                                        scope: this,
                                        success: function(response) {
                                            this.subscriberGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                                        }
                                    });
                                }
                            }
                        });
                    }
                },
                {
                    text: _('ditsnews.subscribers.update'),
                    scope: this,
                    handler: function() {
                        dnCore.ajax.request({
                            url: dnCore.config.connectorUrl,
                            params: {
                                id: this.rowMenu.baseParams.rowId,
                                action: 'mgr/subscribers/get'
                            },
                            scope: this,
                            success: function(response) {
                                var subscriberConfig = Ext.decode(response.responseText);
                                subscriberConfig = subscriberConfig.object;

                                // Set form values
                                this.newSubscriberForm.getForm().setValues(subscriberConfig);
                                this.newSubscriberWindow.setTitle( _('ditsnews.subscribers.update'));
                                this.newSubscriberWindow.show();

                                //groups
                                this.getGroups(this.rowMenu.baseParams.rowId);
                            }
                        });
                    }
                }

            ]
        });


		this.newSubscriberForm = new Ext.form.FormPanel({
			border: false,
			labelWidth: 150,
			monitorValid: true,
            plugins:[
                new Ext.ux.FormClear()
            ],
			buttons: [
				{
					text:  _('cancel'),
					scope: this,
					handler: function() {
						this.newSubscriberWindow.hide();
					}
				},
				{
					text:  _('save'),
					formBind: true,
					scope: this,
					handler: function() {
						var postData = {
							formData: Ext.encode(this.newSubscriberForm.getForm().getFieldValues()),
							action: 'mgr/subscribers/save'
						}

						dnCore.ajax.request({
							url: dnCore.config.connectorUrl,
							params: postData,
							scope: this,
							success: function(response) {
                                var status = Ext.decode(response.responseText);
                                if(status.success == true) {
                                    this.subscriberGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                                    this.newSubscriberForm.getForm().reset();
                                    this.newSubscriberWindow.hide();
                                    dnCore.showMessage(_('ditsnews.subscribers.saved'));
                                } else {
                                    dnCore.showMessage(_('ditsnews.subscribers.error'));
                                }
							}
						});
					}
				}
			],
			items: [
				{
                    layout: 'form',
                    id: 'new-subscriber-form',
                    items: [
                        {
                            xtype: 'hidden',
                            name: 'id',
                            id: 'subscriber-id'
                        },
                        {
                            xtype: 'checkbox',
                            name: 'active',
                            id: 'subscriber-active',
                            fieldLabel: _('ditsnews.subscribers.active'),
                            inputValue: 1
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.subscribers.firstname'),
                            name: 'firstname',
                            allowBlank: true
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.subscribers.lastname'),
                            name: 'lastname',
                            allowBlank: true
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.subscribers.company'),
                            name: 'company',
                            allowBlank: true
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.subscribers.email'),
                            name: 'email',
                            allowBlank: false
                        },
                        {
                            xtype: 'fieldset',
                            id: 'subscribergroups',
                            title: _('ditsnews.subscribers.groups'),
                            items: []
                        }
                    ]
                }
			]
		});

		this.newSubscriberWindow = new Ext.Window({
			padding: 10,
			title: _('ditsnews.subscribers.new'),
			width: 750,
			y: 20,
			autoHeight: true,
			closeAction: 'hide',
			items: [
				this.newSubscriberForm
			]
		});

		this.importForm = new Ext.form.FormPanel({
			border: false,
			labelWidth: 150,
			monitorValid: true,
            fileUpload: true,            
			buttons: [
				{
					text: _('cancel'),
					scope: this,
					handler: function() {
						this.importWindow.hide();
					}
				},
				{
					text: _('ditsnews.subscribers.importcsv.start'),
					formBind: true,
					scope: this,
					handler: function() {
                        this.importForm.getForm().submit({
                            url: dnCore.config.connectorUrl+'?action=mgr/subscribers/import&HTTP_MODAUTH='+dnCore.siteId,
                            waitMsg: _('upf_uploading'),
                            scope: this,
                            success: function(fp, response) {
                                var msg = Ext.decode(response.response.responseText);
                                Ext.getCmp('import-status').show();
                                Ext.getCmp('import-status').update( '<b>'+_('ditsnews.subscribers.importcsv.results')+'</b><br/>'+Ext.util.Format.htmlDecode(msg.message));
                                this.subscriberGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                            }
                        });
					}
				}
			],
			items: [
				{
                    layout: 'form',
                    id: 'import-form',
                    items: [
                        {
                            xtype: 'textfield',
                            inputType: 'file',
                            fieldLabel: _('ditsnews.subscribers.importcsv.file'),
                            name: 'csv',
                            allowBlank: false
                        }
                    ]
                },
                {
                    id: 'import-status',
                    hidden: true
                }
			]
		});

		this.importWindow = new Ext.Window({
			padding: 10,
			title: _('ditsnews.subscribers.importcsv'),
			width: 750,
			y: 20,
			autoHeight: true,
			closeAction: 'hide',
			items: [
				this.importForm
			]
		});


        this.subscriberGrid = new Ext.grid.GridPanel({
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
            store: dnCore.stores.subscribers,
            tbar: [
                {
					xtype: 'button',
					text:  _('ditsnews.subscribers.new'),
					scope: this,
					handler: function() {
                        this.newSubscriberWindow.show();
                        this.newSubscriberWindow.setTitle( _('ditsnews.subscribers.new'));
                        this.newSubscriberForm.getForm().reset();
                        this.newSubscriberForm.getForm().setValues({
							id: 0,
                            firstname: '',
                            lastname: '',
                            company: '',
                            email: ''
						});
                        Ext.getCmp('subscriber-id').setValue(0);
                        Ext.getCmp('subscriber-active').setValue(1);                        
                        this.getGroups(0);
					}
                },
                {
					xtype: 'button',
					text: _('ditsnews.subscribers.exportcsv'),
					scope: this,
					handler: function() {
                        location.href=dnCore.config.connectorUrl+'?action=mgr/subscribers/export&HTTP_MODAUTH='+dnCore.siteId;
                    }
                },
                {
					xtype: 'button',
					text:  _('ditsnews.subscribers.importcsv'),
					scope: this,
					handler: function() {
                        Ext.getCmp('import-status').hide();
                        this.importForm.getForm().reset();
                        this.importWindow.show();
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
                        dataIndex: 'email',
                        header:  _('ditsnews.subscribers.email'),
                        sortable: true
                    },                    
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'firstname',
                        header:  _('ditsnews.subscribers.firstname'),
                        sortable: true
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'lastname',
                        header:  _('ditsnews.subscribers.lastname'),
                        sortable: true
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'company',
                        header:  _('ditsnews.subscribers.company'),
                        sortable: true
                    }
            ],
            bbar: new Ext.PagingToolbar({
                pageSize: dnCore.pageSize,
                displayInfo: true,
                emptyMsg:  _('no_records_found'),
                store: dnCore.stores.subscribers
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
                        this.rowMenu.baseParams.rowId = dnCore.stores.subscribers.getAt(rowIndex).get('id');
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
				this.subscriberGrid
			]
		});
	},
    getGroups: function(subscriberId) {
            dnCore.ajax.request({
                url: dnCore.config.connectorUrl,
                params: {
                    action: 'mgr/groups/getgroups',
                    subscriberId: subscriberId
                },
                scope: this,
                success: function(response) {
                    var groups = Ext.decode(response.responseText);
                    groups = groups.object;

                    Ext.getCmp('subscribergroups').removeAll();

                    if(groups.length > 0) {
                        Ext.each(groups, function(item, key) {
                                    Ext.getCmp('subscribergroups').add({
                                        xtype: 'checkbox',
                                        name: 'groups_'+item.id,
                                        fieldLabel: item.name,
                                        inputValue: true,
                                        checked: item.checked
                                    });
                        }, this);
                    }
                   this.newSubscriberForm.doLayout(false, true);
                }
            });
    }
});

Ext.onReady(function() {
	// Set page title
	dnCore.setTitle(_('ditsnews.subscribers'));

    // this makes the main class accessible through dnCore.pageClass and the panel through dnCore.pagePanel
    dnCore.loadPanel(dnPageSubscribers);
});