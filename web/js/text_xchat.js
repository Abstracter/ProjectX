$('.emojis-plain').emojiarea({wysiwyg: false});
		
		var $wysiwyg = $('.emojis-wysiwyg').emojiarea({wysiwyg: true});
		var $wysiwyg_value = $('#emojis-wysiwyg-value');
                
		
           
		$wysiwyg.on('change', function() {
			$wysiwyg_value.text($(this).val());
		});
		$wysiwyg.trigger('change');
            
