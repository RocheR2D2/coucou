/**
 * Theme: Webadmin
 * Form Advanced
 */

!function($) {
    "use strict";

    var AdvancedForm = function() {};
    
    AdvancedForm.prototype.init = function() {


       jQuery('#endTime').datepicker({
           autoclose: true,
           toggleActive: true,
           todayHighlight:true,
           language: 'fr',
           endDate: new Date()
       }).on('changeDate',function(e){
           var endTime = e.date;
           $('#beginTime').datepicker('setEndDate',endTime);
       });


    },
    //init
    $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.AdvancedForm.init();
}(window.jQuery);