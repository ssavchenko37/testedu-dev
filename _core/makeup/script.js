"use strict"
document.documentElement.classList.add('navbar-vertical-collapsed');

const iBookCtrl = () => {
	const ibook_id = document.getElementById('ibook_id').value;
	const editable = document.getElementsByClassName('showed');

	for (let col of editable) {
		col.addEventListener('click', (e) => {
			console.log(e.target.tagName);
			if (e.target.tagName !== "SPAN") return;
			const span = e.target;
			const td = span.closest('td');

			const isAbs = (td.classList.contains('bg-abs')) ? 0: 1;
			const dataSend = { ibook_id: ibook_id, mode: 'trigger_abs', 'rate': isAbs, item_id: td.dataset.item_id}
				
			fetch('/_core' + window.location.pathname + 'ajax/save-edited.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(dataSend)
			})
			.then(response => response.json())
			.then(data => {
				console.log(data);
				if (data.status === 'success') {
					td.classList.remove('bg-abs');
					td.classList.remove('bg-reabs');
					td.classList.add(data.trigger_class);
				}
			})
			.catch(error => {
				console.error('There was a problem with the fetch operation:', error);
			});
		});
	}
}

docReady(iBookCtrl);