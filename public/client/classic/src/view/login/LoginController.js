Ext.define('MyApp.view.login.LoginController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.login-login',

    onButtonLoginClick: function(button) {
        var me = this;

        var form = this.lookup('loginform');
        form.submit({
            url: '/auth',
            success: function(form, action) {
                //Ext.MessageBox.alert('Berhasi', 'Sukses Login!');
                
                me.getView().destroy();
                Ext.create({
                    xtype:'app-main'
                });
            },
            failure: function(form, action) {
                if(action.response!=null) {
                    var data = JSON.parse(action.response.responseText);
                    if(data!=null) {
                        Ext.MessageBox.alert('Error', data.data.message);    
                    } else {
                        Ext.MessageBox.alert('Error', action.response.statusText);
                    }
                }
            }
        })        

    }

});
