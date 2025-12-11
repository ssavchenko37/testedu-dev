"use strict"

const validateForm = () => {
	const subject_id = document.getElementById('subject_id');
	const grm_id = document.getElementById('grm_id');
	const grup_ids = document.getElementById('grup_ids');
	let is_stype = false;

	if (grm_id.options[ grm_id.selectedIndex ] === undefined) return;

	for(let chk of document.getElementsByClassName('form-check-input')) {
		if (chk.checked) {
			is_stype = true;
		}
	}

	if (
		parseInt(subject_id.options[ subject_id.selectedIndex ].value) > 0 &&
		parseInt(grm_id.options[ grm_id.selectedIndex ].value) > 0 &&
		grup_ids.selectedOptions.length > 0 && is_stype
	) {
		document.getElementById('action_subj').disabled = false
	}
}
const buildGroups = () => {
	const subject_id = document.getElementById('subject_id');
	const subjectID = parseInt(subject_id.options[ subject_id.selectedIndex ].value);
	const grm_id = document.getElementById('grm_id');
	const grmID = parseInt(grm_id.options[ grm_id.selectedIndex ].value);
	const grup_ids = document.getElementById('grup_ids');
	let stype = "";
	for(let chk of document.getElementsByName('stype')) {
		if (chk.checked) {
			stype = chk.value;
		}
	}
	if (subjectID > 0 && grmID > 0) {
		const dataSend = {
			sid: subjectID,
			gid: grmID,
			stype: stype
		};
		console.log(dataSend);
		fetch('/_core' + window.location.pathname + 'ajax/handlers.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(dataSend)
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === "success") {
				grup_ids.innerHTML = data.options;
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}	
}
const ctrlDept = () => {
	const tsaside = document.getElementById('tsaside-two');
	tsaside.addEventListener('input', (e) => {
		const dcodes = document.getElementById('dcode');
		const scodes = document.getElementById('scode');
		const subject_id = document.getElementById('subject_id');
		const stypeL = document.getElementById('stypeL');
		const stypeP = document.getElementById('stypeP');
		const grm_id = document.getElementById('grm_id');
		const grup_ids = document.getElementById('grup_ids');

		let dcode, scode, grmid;
		
		if (e.target.id === 'dcode') {
			scodes.value = 0;
			subject_id.value = 0;
			grm_id.value = 0;
			grup_ids.innerHTML="";

			dcode = dcodes.options[ dcodes.selectedIndex ].dataset.dcode;
			for(let opt of subject_id.options) {
				opt.disabled = false;
				opt.style.display = 'block';
				if (dcode !== undefined) {
					if (opt.dataset.dcode !== dcode) {
						opt.disabled = true;
						opt.style.display = 'none';
					}
				}
			}
		}
		if (e.target.id === 'scode') {
			dcode = dcodes.options[ dcodes.selectedIndex ].dataset.dcode;
			scode = scodes.options[ scodes.selectedIndex ].dataset.scode;
			subject_id.value = 0;
			grm_id.value = 0;
			grup_ids.innerHTML="";

			[subject_id, grm_id, grup_ids].forEach((e) => {
				for(let opt of e.options) {
					opt.disabled = false;
					opt.style.display = 'block';
					if (dcode !== undefined && opt.dataset.dcode !== undefined) {
						if (opt.dataset.dcode !== dcode) {
							opt.disabled = true;
							opt.style.display = 'none';
						}
					}
					if (scode !== undefined) {
						if (opt.dataset.scode !== scode) {
							opt.disabled = true;
							opt.style.display = 'none';
						}
					}
				}
			});
		}
		if (e.target.id === 'subject_id') {
			dcode = e.target.options[ e.target.selectedIndex ].dataset.dcode;
			scode = e.target.options[ e.target.selectedIndex ].dataset.scode;

			if (dcodes.options[ dcodes.selectedIndex ].dataset.dcode !== dcode) {
				dcodes.value = dcode;
			}
			if (scodes.options[ scodes.selectedIndex ].dataset.scode !== scode) {
				scodes.value = scode;
			}
			[grm_id, grup_ids].forEach((e) => {
				for(let opt of e.options) {
					opt.disabled = false;
					opt.style.display = 'block';
					if (dcode !== undefined && opt.dataset.dcode !== undefined) {
						if (opt.dataset.dcode !== dcode) {
							opt.disabled = true;
							opt.style.display = 'none';
						}
					}
					if (scode !== undefined) {
						if (opt.dataset.scode !== scode) {
							opt.disabled = true;
							opt.style.display = 'none';
						}
					}
				}
			});
		}
		if (e.target.id === 'grm_id') {
			grup_ids.innerHTML="";
			grmid = grm_id.options[ grm_id.selectedIndex ].dataset.grmid;
			for(let opt of grup_ids.options) {
				opt.disabled = false;
				opt.style.display = 'block';
				if (grmid !== undefined) {
					if (opt.dataset.grmid !== grmid) {
						opt.disabled = true;
						opt.style.display = 'none';
					}
				}
			}
			buildGroups();
		}
		if (e.target.id === 'stypeL' || e.target.id === 'stypeP') {
			grup_ids.innerHTML="";
			buildGroups();
		}
		validateForm();
	});
}
docReady(ctrlDept);

const pageInit = () => {
	const tsid = document.getElementById('tsid');
	if (tsid && tsid.value.trim() !== "") {
		// document.getElementById('dcode').dispatchEvent(new Event('input', { bubbles: true }));
		// document.getElementById('scode').dispatchEvent(new Event('input', { bubbles: true }));
		//document.getElementById('subject_id').dispatchEvent(new Event('input', { bubbles: true }));
		//document.getElementById('grm_id').dispatchEvent(new Event('input', { bubbles: true }));
	}	
};