$('#editorder').button().click(function() {
	if (document.getElementById('editorder').value == 'Edit') {
		document.getElementById('editorder').value = 'Update';
		$('#vehiclereg2').prop('disabled', false);
		$('#ordsts').prop('disabled', false);
		$('#comments').prop('disabled', false);
		$('#ordsts').focus();
	} else {
		 var ordernumber = document.getElementById('ordernumber').value;
		 var orderstatus = document.getElementById('ordsts').value;
		 var deliveryvehicle = document.getElementById('vehiclereg2').value;
		 var comments = document.getElementById('comments').value;

		 var dataString = 'orderno='+ordernumber+'&orderstatus='+orderstatus+'&deliveryvehicle='+deliveryvehicle+'&comments='+comments;

		 if(ordernumber==''){
		 	alert('Please fill in all fields');
		 } else if(orderstatus=='') {
		 	alert('Please fill in order status');
		 } else if(deliveryvehicle=='') {
		 	alert('Please fill in deliveryvehicle');
		 } else {
			 $.ajax({
			 	type: "POST",
			 	url: "updatedelivery.php",
			 	data: dataString,
			 	cache: false,
			 	success: function(result) {
			 		alert("ORDER IS SUCCESSFULLY UPDATED");
			 	}
			 });
			 document.getElementById('editorder').value = 'Edit';
		 $('#ordsts').prop('disabled', true);
		 $('#vehiclereg2').prop('disabled', true);
		 $('#comments').prop('disabled', true);
		}
	}
});

$('.rad').on('mouseenter mouseleave', function () {
  $('.box').toggleClass('open');
});