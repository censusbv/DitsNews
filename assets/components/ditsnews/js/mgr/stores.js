dnCore.stores.newsletters = new Ext.data.JsonStore({
    root: 'results',
    idProperty: 'id',
    url: dnCore.config.connectorUrl,
    baseParams: {
    	action: 'mgr/newsletters/list'
    },
    fields: [
        'id', 'title','date','total','sent'
    ]
});


dnCore.stores.documents = new Ext.data.JsonStore({
    root: 'results',
    idProperty: 'id',
    url: dnCore.config.connectorUrl,
    baseParams: {
    	action: 'mgr/documents/list'
    },
    fields: [
        'id', 'pagetitle'
    ]
});

dnCore.stores.groups = new Ext.data.JsonStore({
    root: 'results',
    idProperty: 'id',
    url: dnCore.config.connectorUrl,
    baseParams: {
    	action: 'mgr/groups/list'
    },
    fields: [
        'id', 'name', 'public', 'members'
    ]
});

dnCore.stores.subscribers = new Ext.data.JsonStore({
    root: 'results',
    idProperty: 'id',
    url: dnCore.config.connectorUrl,
    baseParams: {
    	action: 'mgr/subscribers/list'
    },
    fields: [
        'id', 'firstname', 'lastname', 'company', 'email'
    ]
});