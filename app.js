$(function() {
	$('#f1').on('submit', function() {
		let num = parseInt($('#num').val());
		let c_id = $('#c_id').val();
		let g_id = $('#g_id').val();
		if(num < 1 || num > 1000) {
			$('#msg').text('異常な値です');
			return false;
		}
		if(c_id == '' || g_id == '') {
			$('#msg').text('未選択項目があります');
			return false;
		}
		});
		$('#num').on('change', function() {
			let subtotal = parseInt($(this).val()) * 100;
			$('#subtotal').text(subtotal + '円');
		});
});
