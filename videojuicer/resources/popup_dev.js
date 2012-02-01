var videojuicer_popup = {
	
	editor : tinyMCEPopup.editor,

	settings : '',

	form : null,

	submit : function() {

		var map = [
			{setting : 'presentation' , field : 'presentation'},
			{setting : 'seed' , field : 'seed_id'},
			{setting : 'width' , field : 'width'},
			{setting : 'height' , field : 'height'}
		];

		var string = '';

		console.log(this.settings);

		for ( var i = 0; i < map.length; i++ ) {
			var v = document.getElementById(map[i].field);
			string += ( v.value && v.value != this.settings[map[i].field] ) ? ' '+map[i].setting+'='+v.value : '';
		}

		var shortcode = '[videojuicer '+string+']';

		this.editor.execCommand('mceInsertContent', false , shortcode);

		tinyMCEPopup.close();

		return false;
	},

	init : function() {
		this.settings = parent.videojuicer_settings;

		this.form = document.getElementById('data');

		for ( var i = 0; i < this.form.elements.length; i++ ) 
		{
			this.form.elements[i].value += this.settings[this.form.elements[i].id] || '';
		}
	}

}

tinyMCEPopup.onInit.add(videojuicer_popup.init , videojuicer_popup);1