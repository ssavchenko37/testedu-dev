"use strict"
document.documentElement.classList.add('navbar-vertical-collapsed');

const calcFinalScores = function() {
	const $wrap = document.getElementsByClassName('table-meta')[0];
	if ($wrap) {
		$wrap.querySelectorAll('.table > tbody > tr').forEach((tr) => {
			calcFinalScore(tr);
		});
	}
}

const calcFinalScore = (tr) => {
	let final = 0;
	let d = 0;
	let non = 0;

	const totals = tr.querySelectorAll('td[class*="total"]');
	const finalCell = tr.getElementsByClassName('final_score')[0];
	totals.forEach((totalCell) => {
		const ttl = parseInt(totalCell.innerText);
		if (ttl > 0) {
			d++;
			final += ttl;
		}
		if (ttl < 60 && ttl !== NaN) {
			non++;
		}
	});
	if (d > 0 && non === 0) {
		finalCell.innerText = Math.round(final/d);
	}
	if (non > 0) {
		finalCell.innerText = 'н/д';
	}
}

const calcUnits = (tr, data) => {
	const unititems = tr.querySelectorAll('td[data-unit_num="' + data.unit_num + '"]');
	unititems.forEach((uitm) => {
		uitm.dataset.unit_id = data.unit_id;
	});
	if (data.total === 0) {
		data.total = '';
	}
	tr.getElementsByClassName('total' + data.unit_num)[0].getElementsByTagName('STRONG')[0].innerHTML = data.total;
	calcFinalScore(tr);
}

const iBookCtrl = () => {
	const ibook_id = document.getElementById('ibook_id').value;
	const enteredHandler = (col) => {
		const coldate = col.getElementsByTagName('INPUT')[0];
		const colitems = document.querySelectorAll('span[data-send="' + coldate.id + '"]');
		const colalt = col.getElementsByClassName('entered-alt')[0];
		const meta_id = col.dataset.meta_id;
		const dataSend = { ibook_id: ibook_id, meta_id: meta_id, meta_date: coldate.value, meta_uin: coldate.id }
		fetch('/api' + window.location.pathname + 'meta-entered', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(dataSend)
		})
		.then(response => response.json())
		.then(data => {
			col.dataset.meta_id = data.meta_id;
			colalt.innerHTML = data.monthday;
			colitems.forEach((itm) => {
				if (itm.dataset.field !== undefined) {
					const b = itm.getElementsByTagName('B')[0];
					itm.closest('td').dataset.meta_id = data.meta_id;
					if (itm.dataset.field === "meta_class") {
						b.innerHTML = data.meta_class;
					}
					if (itm.dataset.field === "meta_hours") {
						b.innerHTML = data.meta_hours;
					}
				}
			});
		})
		.catch(error => console.error('Ошибка:', error));
	}
	const dateHandler = () => {
		const entered = document.getElementsByClassName('entered');
		for (let col of entered) {
			const coldate = col.getElementsByTagName('INPUT')[0]; 
			let datetime = '';
			if (typeof coldate.value === "string" && coldate.value.length > 0) {
				datetime = coldate.value;
			}
			flatpickr(coldate, {
				allowInput: true,
				enableTime: false,
				dateFormat: "Y-m-d",
				locale: "ru",
				defaultDate: datetime,
				onChange: function() {
					enteredHandler(col);
				}
			});
			const fp = coldate._flatpickr;

			document.addEventListener("keydown", (e) => {
				if (e.key === "Escape") {
					if (fp.isOpen) fp.close();
				}
			});
		}
	};

	const editedHandler = () => {
		const editable = document.getElementsByClassName('edited');
		for (let col of editable) {
			col.addEventListener('click', (e) => {
				if (e.target.tagName !== "B") return;
				const elB = e.target;
				const tr = elB.closest('tr');
				const td = elB.closest('td');
				const span = elB.closest('span');                
				const entered = document.getElementById(span.dataset.send);
				if (!td.classList.contains('edited_unit')) {
					if (entered.value === '') {
						entered._flatpickr.open();
						return;
					}
				}
				const stud_id = tr.dataset.send;
				let val = elB.innerText;
				const abs = document.createElement('DIV');
				abs.className = 'abs';
				const input = document.createElement('input');
				input.type = 'text';
				input.name = 'e';
				input.value = val;
				span.replaceChildren(input);
				input.focus();
				input.addEventListener('blur', (e) =>{
					let newVal = e.target.value;
					let dataSend = {};
					
					if (newVal !== val) { 
						if (td.classList.contains('edited_val')) {
							dataSend = { ibook_id: ibook_id, mode: 'edited_val', 'rate': newVal, item_uin: span.dataset.send, stud_id: stud_id, item_id: td.dataset.item_id}
						}
						if (td.classList.contains('edited_meta')) {
							dataSend = { ibook_id: ibook_id, mode: 'edited_meta', 'rate': newVal, meta_id: td.dataset.meta_id, field: span.dataset.field}
						}
						if (td.classList.contains('edited_unit')) {
							dataSend = { ibook_id: ibook_id, mode: 'edited_unit', 'rate': newVal, stud_id: stud_id, unit_id: td.dataset.unit_id, unit_num: td.dataset.unit_num, field: span.dataset.send}
						}
						fetch('/api' + window.location.pathname + 'save-edited', {
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
								if (td.classList.contains('edited_val')) {
									if (data.item_id !== undefined) {
										td.dataset.item_id = data.item_id;
									}
								}
								if (td.classList.contains('edited_unit')) {
									calcUnits(tr, data);
								}
								span.innerHTML = '<b>' + data.value + '</b>';
							} else {
								span.innerHTML = '<b>&nbsp;</b>';
							}
						})
						.catch(error => {
							console.error('There was a problem with the fetch operation:', error);
						});
					} else {
						span.innerHTML = '<b>' + val +'</b>';
					}
					setTimeout(() => {
						abs.remove();
					}, 300);
				});
				if (td.classList.contains('edited_val')) {
					td.appendChild(abs);
					td.addEventListener('click', (e) => {
						if (e.target.className !== "abs") return;
						const dataSend = { ibook_id: ibook_id, mode: 'edited_val', 'rate': 'abs', item_uin: span.dataset.send, stud_id: stud_id, item_id: td.dataset.item_id}
						fetch('/api' + window.location.pathname + 'save-edited', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json'
							},
							body: JSON.stringify(dataSend)
						})
						.then(response => response.json())
						.then(data => {
							if (data.status === 'success') {
								if (td.classList.contains('edited_val')) {
									td.dataset.item_id = data.item_id;
									td.className = 'align-middle text-center bg-abs';
									td.innerHTML = data.value;
								}						
							} else {
								span.innerHTML = '<b>&nbsp;</b>';
							}
							abs.remove();
						})
					});
				}
			});
		}
	}

	dateHandler();
	editedHandler();
	calcFinalScores();
}

docReady(iBookCtrl);