jQuery(document).ready(function($) {
	/* the quiz */
	let qfttags = [];
	$('.qft-answer').on('click', function(e){
		e.preventDefault();
		const qftanswer = $(this).attr("value");
		qfttags.push(qftanswer);
		$('#qft-tags').val(qfttags.join(", "));
		$(this).closest('.qft-step').fadeOut(function(){
			$(this).closest('.qft-step').next('.qft-step').fadeIn();
		});
	});
	
	/* actually search */
	$('#qft-search').click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: qft_ajax_object.ajaxurl,
			data: {
				action: 'qft_ajax_search', // Match the action hook name
				data: $('#qft-tags').val()
			},
			success: function(response) {
				$('.qft-step').fadeOut();
				$('#qft-result').html(response);
			}
		});
	});
});