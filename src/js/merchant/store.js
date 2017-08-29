var storeCreator = Class.create();
storeCreator.prototype = {
    initialize : function(getCityUrl, cityEl, stateEl, selectedCityId) {
        this.getCityUrl = getCityUrl;
        this.selectedCityId = 0;
        if ($(selectedCityId) != 'undefined') {
            this.selectedCityId  = $(selectedCityId).getValue();
        }
        if (($(cityEl) != 'undefined') && ($(stateEl) != 'undefined')){
            this.cityElement = $(cityEl);
            this.stateElement = $(stateEl);
            Event.observe(this.stateElement, 'change', this.getCity.bind(this));
        }

    },
    getCity : function () {
        new Ajax.Request(this.getCityUrl, {
            method: 'get',
            parameters: {
                'state':this.stateElement.getValue(),
                'selected_city_id' : this.selectedCityId
            },
            onLoading: function (stateform) {
            },
            onComplete:this.update.bind(this),
        });
    },
    update: function(transport){
        if (transport.responseText) {
            this.cityElement.update(transport.responseText);
        }
    }
};
