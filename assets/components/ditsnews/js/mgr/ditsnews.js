var Ditsnews = function(config) {
    config = config || {};
    Ditsnews.superclass.constructor.call(this,config);
};

Ext.extend(Ditsnews, Ext.Component, {
	initComponent: function() {
		this.loadMask = new Ext.LoadMask(Ext.getBody(), {msg: 'Loading, please wait...'});
		this.messageWindow = null;
		this.siteId = siteId;
		this.pagePanel = null;
		this.pageClass = null;
		this.stores = {};
		this.config = {};
		this.tasks = {};
        this.pageSize = 10;
        this.mainMenu = [
            new Ext.Action({
                    text: _('ditsnews.newsletters'),
                    scope: this,
                    handler: function(){
                        window.location.href='/manager/?a='+this.getUrlVar('a')+'&action=newsletters';
                    }
            }),
            new Ext.Action({
                    text: _('ditsnews.groups'),
                    scope: this,
                    handler: function(){
                        window.location.href='/manager/?a='+this.getUrlVar('a')+'&action=groups';
                    }
            }),
            new Ext.Action({
                    text: _('ditsnews.subscribers'),
                    scope: this,
                    handler: function(){
                        window.location.href='/manager/?a='+this.getUrlVar('a')+'&action=subscribers';
                    }
            }),
            new Ext.Action({
                    text: _('ditsnews.settings'),
                    scope: this,
                    handler: function(){
                        window.location.href='/manager/?a='+this.getUrlVar('a')+'&action=settings';
                    }
            })
        ];
        
		Ext.onReady(function() {
			if (Ext.get('ditsnews-container')) {
				    this.mainPanel = new Ext.Panel({
					renderTo: 'ditsnews-container',
					border: false,
					autoHeight: true,
					unstyled: true,
					baseCls: 'ditsnews-mainpanel',
					items: [
						{
							html: '<h2 id="ditsnews-title"></h2>',
							border: false,
							cls: 'modx-page-header'
						},
						{
							html: '<div id="ditsnews-content"></div>',
							border: false,
							unstyled: true
						}
					]
				});
			}
		});

		this.ajax = new Ext.data.Connection({
			disableCaching: true,
			extraParams: {
				HTTP_MODAUTH: this.siteId
			}
		});

		this.ajax.on('beforerequest', function() {
			this.showAjaxLoader();
		}, this);

		this.ajax.on('requestcomplete', function() {
			this.hideAjaxLoader();
		}, this);

		this.ajax.on('requestexception', function() {
			this.hideAjaxLoader();
		}, this);
	},
	showMessage: function(message) {
		if (!this.messageWindow) {
			this.messageWindow = new Ext.Window({
				closable: false,
				resizable: false,
				unstyled: true,
				shadow: false,
				y: -50,
				bodyStyle: {
					backgroundColor: '#FFFFFF',
					padding: '10px',
					border: '2px solid #666666',
					borderRadius: '10px',
					'-moz-border-radius': '10px',
					'-webkit-border-radius': '10px',
					fontWeight: 'bold',
					zIndex: 999999
				}
			});

			this.messageWindow.show();
			this.messageWindowEl = this.messageWindow.getEl();

			this.tasks.hideMessage = new Ext.util.DelayedTask(function() {
				this.hideMessage();
			}, this);

			Ext.getBody().appendChild(this.messageWindowEl);
		}

		// Set styles
		Ext.get(this.messageWindow.getId()).setStyle('z-index', '999999');
		this.messageWindowEl.setOpacity(0);
		this.messageWindowEl.setOpacity(1, true);
		this.messageWindowEl.setY(10, true);

		// Update message
		this.messageWindow.update(message);

		// Hide after 3 seconds
		this.tasks.hideMessage.delay(3000);
	},
	hideMessage: function() {
		this.messageWindowEl.setY(-50, true);
		this.messageWindowEl.setOpacity(0, true);
	},
	showAjaxLoader: function() {
		this.loadMask.show();
	},
	hideAjaxLoader: function() {
		this.loadMask.hide();
	},
	loadPanel: function(panelClass) {
		this.pageClass = new panelClass();
		this.pagePanel = this.pageClass.mainPanel;
	},
	setTitle: function(title) {
		Ext.get('ditsnews-title').update(title);
	},
	getUrlVar: function(key) {
		// Thanks to: http://snipplr.com/users/Roshambo/
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        if (hash[0] == key) {
	        	return hash[1];
	        }
	    }

	    return '';
    }
});

Ext.reg('ditsnews', Ditsnews);

var dnCore = new Ditsnews();