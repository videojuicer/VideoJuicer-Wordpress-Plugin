var videojuicer_popup = {
	
	editor : tinyMCEPopup.editor,

	submit : function() {

		var data = [],
			params = '';
		
		var presentation = ' presentation="'+document.getElementById('presentation').value+'"';
		var width = document.getElementById('width').value ? ' width="'+document.getElementById('width').value+'"' : '';
		var height = document.getElementById('height').value ? ' height="'+document.getElementById('height').value+'"':'' ;
		var seed = document.getElementById('seed').value ? ' seed="'+document.getElementById('seed').value+'"' : '';

		var shortcode = '[videojuicer '+presentation+width+height+seed+']';

		this.editor.execCommand('mceInsertContent', false , shortcode);

		tinyMCEPopup.close();

		return false;
	}

}