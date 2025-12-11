"use strict"

const validateForm = () => {
	const subject_id = document.getElementById('subject_id');
	const grm_id = document.getElementById('grm_id');
	const grup_ids = document.getElementById('grup_ids');
	let is_stype = false;

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
const ctrlDept = () => {
	const tsaside = document.getElementById('tsaside-two');
	tsaside.addEventListener('input', (e) => {
		const dcodes = document.getElementById('dcode');
		const scodes = document.getElementById('scode');
		const subject_id = document.getElementById('subject_id');
		const grm_id = document.getElementById('grm_id');
		const grup_ids = document.getElementById('grup_ids');

		let dcode, scode, grmid;

		if (e.target.id === 'dcode') {
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
		if (e.target.id === 'grm_id') {
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
		}
		if (e.target.id === 'subject_id') {
			dcode = e.target.options[ e.target.selectedIndex ].dataset.dcode;
			scode = e.target.options[ e.target.selectedIndex ].dataset.scode;

			if (dcodes.options[ dcodes.selectedIndex ].dataset.dcode === undefined) {
				dcodes.value = dcode;
			}
			if (scodes.options[ scodes.selectedIndex ].dataset.scode === undefined) {
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
		validateForm();
	});
}
docReady(ctrlDept);
