// Check if #a2_field_request_invoice select option is "yes" without jQuery
document
	.getElementById('a2_field_request_invoice')
	.addEventListener('change', function () {
		let labelPiva = document.querySelector('label[for="a2_field_piva"] span');
		console.log(labelPiva.innerHTML);
		if (this.value === 'yes') {
			labelPiva.innerHTML = '*';
			labelPiva.classList.add('required');
		} else {
			labelPiva.innerHTML = '(OPZIONALE)';
			labelPiva.classList.remove('required');
		}
	});
