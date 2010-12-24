var dnPageSettings = Ext.extend(Ext.Panel, {
	initComponent: function() {
		this.settingsForm = new Ext.form.FormPanel({
			border: false,
			labelWidth: 150,
			monitorValid: true,
            tbar: [
                {xtype: 'tbfill'},
                {
                    text: _('ditsnews.menu'),
                    menu: [dnCore.mainMenu]
                }
            ],
			buttons: [
				{
					text:  _('save'),
					formBind: true,
					scope: this,
					handler: function() {
						var postData = {
							formData: Ext.encode(this.settingsForm.getForm().getFieldValues()),
							action: 'mgr/settings/save'
						}
						dnCore.ajax.request({
							url: dnCore.config.connectorUrl,
							params: postData,
							scope: this,
							success: function(response) {
                                var status = Ext.decode(response.responseText);
                                if(status.success == true) {
                                    dnCore.showMessage(_('ditsnews.settings.saved'));
                                } else {
                                    dnCore.showMessage(_('ditsnews.settings.error'));
                                }
							}
						});
					}
				}
			],
			items: [
				{
                    layout: 'form',
                    id: 'settings-form',
                    items: [
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.name'),
                            name: 'name',
                            allowBlank: false
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.email'),
                            name: 'email',
                            allowBlank: false
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.bounceemail'),
                            name: 'bounceemail',
                            allowBlank: false
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.confirmpage'),
                            name: 'confirmpage',
                            allowBlank: false
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.unsubscribepage'),
                            name: 'unsubscribepage',
                            allowBlank: false
                        },
                        {
                            xtype: 'textfield',
                            fieldLabel: _('ditsnews.settings.template'),
                            name: 'template',
                            allowBlank: false
                        }
                    ]
                }
			],
            listeners: {
                added: {
                    fn: function() {
                        dnCore.ajax.request({
                            url: dnCore.config.connectorUrl,
                            params: {
                                action: 'mgr/settings/get'
                            },
                            scope: this,
                            success: function(response) {
                                var settingsConfig = Ext.decode(response.responseText);
                                settingsConfig = settingsConfig.object;

                                // Set form values
                                this.getForm().setValues(settingsConfig);
                            }
                        });
                    }
                }
            }
		});

		// The mainpanel always has to be in the "this.mainPanel" variable
		this.mainPanel = new Ext.Panel({
			renderTo: 'ditsnews-content',
			padding: 15,
			border: false,
			items: [
				this.settingsForm
			]
		});
	}
});

Ext.onReady(function() {
	// Set page title
	dnCore.setTitle(_('ditsnews.settings'));

    // this makes the main class accessible through dnCore.pageClass and the panel through dnCore.pagePanel
    dnCore.loadPanel(dnPageSettings);
});