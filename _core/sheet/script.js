"use strict"
document.documentElement.classList.add('navbar-vertical-collapsed');

const summaryCalcHandler = () => {
	const exam_id = document.getElementById('exam_id').value;
	const sheet_id = document.getElementById('sheet_id').value;
	const s_credits = document.getElementById('s_credits').value;

	const enteredHandler = (inpdate) => {
		const dataSend = { mode: 'date', sheet_id: sheet_id, m_date: inpdate.value, module: inpdate.id }
		fetch('/_core' + window.location.pathname + 'ajax/save-sheet-data.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(dataSend)
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success') {
				inpdate.value = data.date;
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}
	const moduleDateHandler = () => {
		const entered = document.getElementsByClassName('entered');
		for (let inpdate of entered) {
			let datetime = '';
			if (typeof inpdate.value === "string" && inpdate.value.length > 0) {
				datetime = inpdate.value;
			}
			flatpickr(inpdate, {
				allowInput: true,
				enableTime: false,
				dateFormat: "Y-m-d",
				locale: "ru",
				defaultDate: datetime,
				onChange: function() {
					enteredHandler(inpdate);
				}
			});
			const fp = inpdate._flatpickr;

			document.addEventListener("keydown", (e) => {
				if (e.key === "Escape") {
					if (fp.isOpen) fp.close();
				}
			});
		}
	};
	moduleDateHandler();

	document.getElementById('assist').addEventListener('blur', (e) => {
		const inpassist = e.currentTarget;
		const dataSend = { mode: 'assist', sheet_id: sheet_id, assist: inpassist.value }
		fetch('/_core' + window.location.pathname + 'ajax/save-sheet-data.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(dataSend)
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success') {
				inpassist.value = data.assist;
			}
		})
		.catch(error => console.error('Ошибка:', error));
	});

	document.getElementById('update-modules').addEventListener('click', () => {
		const inputModules = document.getElementById('modules');
		const modalBtn = document.getElementById('doUpdModules');
		const modalModules = document.getElementById('modulesQty');
		if (s_credits === inputModules.value) return;

		if (modalModules) {
			const myModal = new bootstrap.Modal(modalModules, {backdrop: true});
			myModal.show();
			// modalBtn.addEventListener('click', () => {
			// 	const dataSend = { mode: 'modules', sheet_id: sheet_id, qty: inputModules.value }
			// 	fetch('/_core' + window.location.pathname + 'ajax/save-sheet-data.php', {
			// 		method: 'POST',
			// 		headers: { 'Content-Type': 'application/json' },
			// 		body: JSON.stringify(dataSend)
			// 	})
			// 	.then(response => response.json())
			// 	.then(data => {
			// 		if (data.status === 'success') {
			// 			console.log(data)
			// 			myModal.hide();
			// 		}
			// 	})
			// 	.catch(error => console.error('Ошибка:', error));
			// });
		}
	});

	const editable = document.getElementsByClassName('edited');
	for (let cell of editable) {
		cell.addEventListener('click', (e) => {
			if (e.target.tagName !== "B") return;
			const elB = e.target;
			const tr = elB.closest('tr');
			const td = elB.closest('td');
			const span = elB.closest('span');  
			const val = parseInt(elB.innerText);
			const field = span.dataset.send;
			const item_id = tr.dataset.send;
			const input = document.createElement('input');
			input.type = 'text';
			input.name = 'e';
			input.value = val;
			span.replaceChildren(input);
			input.focus();
			input.addEventListener('blur', (inp) => {
				let newVal = parseInt(inp.target.value);
				if (newVal !== val) {
					const dataSend = { exam_id: exam_id, item_id: item_id, 'rate': newVal, 'field': field, s_credits: s_credits }

					fetch('/_core' + window.location.pathname + 'ajax/save-rate.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify(dataSend)
					})
					.then(response => response.text())
					.then(text => {
						const data = JSON.parse(text);
						if (data.status === 'success') {
							console.log(data);
							console.log(typeof data.post.exam_id);
							console.log(data.post.exam_id);
						} else {
							span.innerHTML = '<b>' + val + '</b>';
						}
					})
					.catch(error => {
						console.error('There was a problem with the fetch operation:', error);
					});
				} else {
					span.innerHTML = '<b>' + val + '</b>';
				}
			});
		});
	}
}

docReady(summaryCalcHandler);