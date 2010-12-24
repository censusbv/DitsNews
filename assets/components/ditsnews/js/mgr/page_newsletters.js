var dnPageNewsletters = Ext.extend(Ext.Panel, {
	initComponent: function() {

        this.rowMenu = new Ext.menu.Menu({
            baseParams: {
                rowId: null,
                node: null
            },
            items: [
                {
                    text: _('ditsnews.newsletters.remove'),
                    scope: this,
                    handler: function() {
                        Ext.Msg.show({
                            title: _('ditsnews.newsletters.remove.title'),
                            msg: _('ditsnews.newsletters.remove.confirm'),
                            buttons: Ext.Msg.YESNO,
                            scope: this,
                            fn: function(response) {
                                if (response == 'yes') {
                                    var newsletterId = this.rowMenu.baseParams.rowId;
                                    
                                    dnCore.ajax.request({
                                        url: dnCore.config.connectorUrl,
                                        params: {
                                            action: 'mgr/newsletters/remove',
                                            newsletterId: newsletterId
                                        },
                                        scope: this,
                                        success: function(response) {
                                            this.newsletterGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            ]
        });


		this.newNewsletterForm = new Ext.form.FormPanel({
			border: false,
			labelWidth: 150,
			monitorValid: true,
			buttons: [
				{
					text: _('cancel'),
					scope: this,
					handler: function() {
						this.newNewsletterWindow.hide();
					}
				},
				{
					text: _('save'),
					formBind: true,
					scope: this,
					handler: function() {
						var postData = {
							formData: Ext.encode(this.newNewsletterForm.getForm().getFieldValues()),
							action: 'mgr/newsletters/save'
						}

						dnCore.ajax.request({
							url: dnCore.config.connectorUrl,
							params: postData,
							scope: this,
							success: function() {
                                this.newsletterGrid.getStore().load({params: {start:0, limit:dnCore.pageSize}});
								this.newNewsletterWindow.hide();
                                dnCore.showMessage(_('ditsnews.newsletters.saved'));
							}
						});
					}
				}
			],
			items: [
				{
                    layout: 'form',
                    title: _('ditsnews.newsletters.new'),
                    id: 'new-newsletter-form',
                    items: [
                        {
                            xtype: 'hidden',
                            name: 'id',
                            id: 'newsletter-id'
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.newsletters.subject'),
                            name: 'title',
                            allowBlank: false
                        },
                        {
                            xtype: 'combo',
                            displayField: 'pagetitle',
                            valueField: 'id',
                            width: 200,
                            forceSelection: true,
                            store: dnCore.stores.documents,
                            mode: 'remote',
                            triggerAction: 'all',
                            fieldLabel: _('ditsnews.newsletters.document'),
                            name: 'document'
                        }
                    ],
                    listeners: {
                        beforerender: {
                            scope: this,
                            fn: function() {
                                this.getGroups();
                            }
                        }
					}
                }
			]
		});

		this.newNewsletterWindow = new Ext.Window({
			padding: 10,
			title: _('ditsnews.newsletters.new'),
			width: 750,
			y: 20,
			autoHeight: true,
			closeAction: 'hide',
			items: [
				this.newNewsletterForm
			]
		});


        this.newsletterGrid = new Ext.grid.GridPanel({
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
            store: dnCore.stores.newsletters,
            tbar: [
                {
					xtype: 'button',
					text: _('ditsnews.newsletters.new'),
					scope: this,
					handler: function() {
						this.newNewsletterForm.getForm().setValues({
							id: 0,
							name: ''
						});
						this.newNewsletterForm.getForm().reset();
						Ext.getCmp('newsletter-id').setValue(0);
						this.newNewsletterWindow.show();
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
                        dataIndex: 'title',
                        header: _('ditsnews.newsletters.subject'),
                        sortable: true,
                        id: 'newsletter-title'
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'date',
                        header: _('ditsnews.newsletters.date'),
                        sortable: true
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'total',
                        header: _('ditsnews.newsletters.total'),
                        sortable: true
                    },
                    {
                        xtype: 'gridcolumn',
                        dataIndex: 'sent',
                        header: _('ditsnews.newsletters.sent'),
                        sortable: true
                    }
            ],
            autoExpandColumn: 'newsletter-title',
            bbar: new Ext.PagingToolbar({
                pageSize: dnCore.pageSize,
                displayInfo: true,
                emptyMsg: _('no_records_found'),
                store: dnCore.stores.newsletters
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
                        this.rowMenu.baseParams.rowId = dnCore.stores.newsletters.getAt(rowIndex).get('id');
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
				this.newsletterGrid
			]
		});
	},
    getGroups: function() {
            dnCore.ajax.request({
                url: dnCore.config.connectorUrl,
                params: {
                    action: 'mgr/groups/getgroups'
                },
                scope: this,
                success: function(response) {
                    var groups = Ext.decode(response.responseText);
                    groups = groups.object;

                    this.newNewsletterForm.doLayout(false, true);
                    Ext.getCmp('new-newsletter-form').doLayout(false, true);

                    if(groups.length > 0) {
                        var currentFieldset = new Ext.form.FieldSet({
									title: _('ditsnews.newsletters.groups')
						});
                        Ext.each(groups, function(item, key) {
                                    currentFieldset.add({
                                        xtype: 'checkbox',
                                        name: 'groups_'+item.id,
                                        fieldLabel: item.name,
                                        inputValue: true,
                                        checked: false
                                    });
                        }, this);
                        Ext.getCmp('new-newsletter-form').add(currentFieldset);
                    }

                    this.newNewsletterForm.doLayout(false, true);
                    Ext.getCmp('new-newsletter-form').doLayout(false, true);
                }
            });
    }
});

Ext.onReady(function() {
	// Set page title
	dnCore.setTitle(_('ditsnews.newsletters'));

    // this makes the main class accessible through dnCore.pageClass and the panel through dnCore.pagePanel
    dnCore.loadPanel(dnPageNewsletters);
});