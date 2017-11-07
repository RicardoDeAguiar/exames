/**
 * Application logic available globally throughout the app
 */
var app = {

	/** @var landmarks used to screen-scrape the html error output for a friendly message */
	errorLandmarkStart: '<!-- ERROR ',
	errorLandmarkEnd: ' /ERROR -->',

	appendAlert: function(message,style, timeout,containerId) {

		if (!style) style = '';
		if (!timeout) timeout = 0;
		if (!containerId) containerId = 'alert';

		var id = _.uniqueId('alert_');

		var html = '<div id="'+id+'" class="alert '+ this.escapeHtml(style) +'" style="display: none;">'
			+ '<a class="close" data-dismiss="alert">&times;</a>'
			+ '<span>'+ this.escapeHtml(message) +'</span>'
			+ '</div>';

		// scroll the alert message into view
		var container = $('#' + containerId);
		container.append(html);
		container.parent().animate({
			scrollTop: container.offset().top - container.parent().offset().top + container.parent().scrollTop() - 10 // (10 is for top padding)
		});
		
		$('#'+id).slideDown('fast');

		if (timeout > 0) {
			setTimeout("app.removeAlert('"+id+"')",timeout);
		}
	},

	removeAlert: function(id) {

		$("#"+id).slideUp('fast', function(){
			$("#"+id).remove();
		});
	},

	showProgress: function(elementId)
	{
		$('#'+elementId).show();
		// $('#'+elementId).animate({width:'150'},'fast');
	},

	hideProgress: function(elementId)
	{
		setTimeout("$('#"+elementId+"').hide();",100);
		// $('#'+elementId).animate({width:'0'},'fast');
	},

	escapeHtml: function(unsafe) {
		return _.escape(unsafe);
	},
	
	browserSucks: function() {
		isIE6 = navigator.userAgent.match(/msie [6]/i) && !window.XMLHttpRequest;
		isIE7 = navigator.userAgent.match(/msie [7]/i);
		isIE8 = navigator.userAgent.match(/msie [8]/i);
		return isIE6 || isIE7 || isIE8;
	},

	parseDate: function(str, defaultDate) {
		
		// don't re-parse a date obj
		if (str instanceof Date) return str;
		
		if (typeof(defaultDate) == 'undefined') defaultDate = new Date();
		
		// if the value passed in was blank, default to today
		if (str == '' || typeof(str) == 'undefined') {
			if (console) console.log('app.parseDate: empty or undefined date value');
			return defaultDate;
		}

		var d;
		try	{
			var dateTime = str.split(' ');
			
			if (dateTime.length == 1) {
				// if this was a time-only value then add an arbitrary date
				if (dateTime[0].split(':').length > 1)
				{
					dateTime[1] = dateTime[0];
					dateTime[0] = '1970-01-01';
				}
			}
			
			var dateParts = dateTime[0].split('-');
			var timeParts = dateTime.length > 1 ? dateTime[1].split(':') : ['00','00','00'];
			// pad the time with zeros if it wasn't provided
			while (timeParts.length < 3) timeParts[timeParts.length] = '00';
			d = new Date(dateParts[0], dateParts[1]-1, dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
		}
		catch (error) {
			if (console) console.log('app.parseDate: ' + error.message);
			d = defaultDate;
		}

		// if either of these occur then the date wasn't parsed correctly
		if ( typeof(d) == 'undefined' || isNaN(d.getTime()) ) {
			if (console) console.log('app.parseDate: unable to parse date value');
			d = defaultDate;
		}
				
		return d;
	},

	/**
	 * Convenience method for creating an option
	 */
	getOptionHtml: function(val,label,selected)	{
		return '<option value="' + _.escape(val) + '" ' + (selected ? 'selected="selected"' : '') +'>'
			+ _.escape(label)
			+ '</option>';
	},

	getErrorMessage: function(resp) {

		var msg = 'An unknown error occured';
		try	{
			var json = $.parseJSON(resp.responseText);
			msg = json.message;
		} catch (error)	{
			// TODO: possibly use regex or some other more robust way to get details...?
			var parts = resp.responseText.split(app.errorLandmarkStart);

			if (parts.length > 1) {
				var parts2 = parts[1].split(app.errorLandmarkEnd);
				msg = parts2[0];
			}
		}

		return msg ? msg : 'Unknown server error';
	},

	version: 1.1

}