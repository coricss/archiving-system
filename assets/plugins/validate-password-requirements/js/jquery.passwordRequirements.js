(function ($) {
	$.fn.PassRequirements = function (options) {
		
		 var defaults = {
			defaults: true
		 };
			 
		 if(!options ||                  
				options.defaults == true ||  
				options.defaults == undefined   
			){
				if(!options){                 
					options = {};             
				}
				defaults.rules = $.extend({
					minlength: {
						text: "Be at least minLength characters long",
										minLength: 8,
					},
					containSpecialChars: {
						text: "Contain at least minLength special character",
						minLength: 1,
						regex: new RegExp('([^!,%,&,@,#,$,^,*,?,_,~])', 'g')
					},
					containLowercase: {
						text: "Contain at least minLength lower case character",
						minLength: 1,
						regex: new RegExp('[^a-z]', 'g')
					},
					containUppercase: {
						text: "Contain at least minLength upper case character",
						minLength: 1,
						regex: new RegExp('[^A-Z]', 'g')
					},
					containNumbers: {
						text: "Contain at least minLength number",
						minLength: 1,
						regex: new RegExp('[^0-9]', 'g')
					}
				}, options.rules);
			}else{
				defaults = options;    
			}
			var i = 0;
			return this.each(function () {
				if(!defaults.defaults && !defaults.rules){
					console.error('You must pass in your rules if defaults is set to false. Skipping this input with id:[' + this.id + '] with class:[' + this.classList + ']');
					return false;
				}
				var requirementList = "";
			
				$(this).data('pass-req-id', i++);
				$(this).keyup(function () {
					var this_ = $(this);
					Object.getOwnPropertyNames(defaults.rules).forEach(function (val, idx, array) {
						if (this_.val().replace(defaults.rules[val].regex, "").length > defaults.rules[val].minLength - 1) {
							var popover_id= "#"+ this_.attr('aria-describedby');
							$(popover_id).find('#' + val).removeClass('text-danger');
							$(popover_id).find('#' + val).addClass('req-passed text-success');
						} else {
							var popover_id= "#"+ this_.attr('aria-describedby');
							$(popover_id).find('#' + val).addClass('text-danger');
							$(popover_id).find('#' + val).removeClass('req-passed text-success');
						}
					})
				});
				$(this).click(function () {
					var this_ = $(this);
					Object.getOwnPropertyNames(defaults.rules).forEach(function (val, idx, array) {
						if (this_.val().replace(defaults.rules[val].regex, "").length > defaults.rules[val].minLength - 1) {
							var popover_id= "#"+ this_.attr('aria-describedby');
							$(popover_id).find('#' + val).removeClass('text-danger');
							$(popover_id).find('#' + val).addClass('req-passed text-success');
						} else {
						 var popover_id= "#"+ this_.attr('aria-describedby');
						 $(popover_id).find('#' + val).addClass('text-danger');
						 $(popover_id).find('#' + val).removeClass('req-passed text-success');
						}
					})
				});
			
				Object.getOwnPropertyNames(defaults.rules).forEach(function (val, idx, array) {
					requirementList += (("<li class='req-item text-danger font-weight-bold' id='" + val + "'>" + defaults.rules[val].text).replace("minLength", defaults.rules[val].minLength));
				})
				try{
					$(this).popover({
						title: '<strong>Password Requirements</strong>',
						color: 'red',
						trigger: options.trigger ? options.trigger : 'focus',
						html: true,
						placement: options.popoverPlacement ? options.popoverPlacement : 'bottom',
						content: 'Your password should: <ul style="list-style-type: none !important; padding: 0 !important">' + requirementList + '</ul>'
					 

					});
				}catch(e){
					throw new Error('PassRequirements requires Bootstraps Popover plugin');
				}
				$(this).focus(function () {
					$(this).keyup();
				
				});
			});
	};
 
}(jQuery));