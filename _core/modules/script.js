"use strict"

const dateRangeHandler = () => {
	const daterange = document.getElementById('filter_daterange');
	var dates = [];
	if (typeof daterange.value === "string" && daterange.value.length > 0) {
		dates = daterange.value.split(" — ");
	}
	flatpickr(daterange, {
		mode: "range",
		allowInput: true,
		dateFormat: "Y-m-d",
		locale: "ru",
		defaultDate: dates
	});
};
docReady(dateRangeHandler);

const pageInit = () => {
	const pid = document.getElementById('pid');
	if (!pid) return;
	const dataSend = {
		mode: 'module',
		id: pid.value
	};
	fetch('/_core' + window.location.pathname + 'ajax/handlers.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(dataSend)
	})
	.then(response => response.json())
	.then(data => {
		console.log(data);
		moduleHandler(data);
		dateHandler();
	})
	.catch(error => console.error('Ошибка:', error));
};
const dateHandler = () => {
	const moduledate = document.getElementById('module_date');
	var datetime = '';
	if (typeof moduledate.value === "string" && moduledate.value.length > 0) {
		datetime = moduledate.value;
	}
	flatpickr(moduledate, {
		allowInput: true,
		enableTime: true,
		dateFormat: "Y-m-d H:i",
		locale: "ru",
		defaultDate: datetime
	});
};
const moduleHandler = (mdate) => {
	const tutor = document.getElementById('tutor_id');
	const module_subject = document.getElementById('module_subject');
	const module_semester = document.getElementById('module_semester');
	const module_num = document.getElementById('module_num');
	const module_groups = document.getElementById('module_groups');

	const buildGroups = () => {
		module_groups.innerHTML = '';

		const dataSend = {
			mode: 'groups',
			module_id: mdate.module_id,
			tutor_id: tutor.value,
			module_subject: module_subject.value,
			semester: module_semester.value,
			modulenum: module_num.value
		};

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
				module_groups.innerHTML = data.options;
				if (mdate.module_groups !== undefined) {
					const groups = mdate.module_groups.replace(/(^\/)|(\/$)/g, '').split('/');
					// groups.forEach((e) => {
					// 	//$("#module_groups option[value='" + e + "']").prop("selected", true);
					// });
					for (const option of module_groups.options) {
						option.selected = groups.includes(option.value);
					}
				}
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}

	const buildModuleNum = () => {
		module_num.innerHTML = '';
		module_groups.innerHTML = '';

		const dataSend = {
			mode: 'modules',
			tutor_id: tutor.value,
			module_subject: module_subject.value,
			semester: module_semester.value
		};

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
				module_num.innerHTML = data.options;
				if (mdate.mdl !== undefined) {
					module_num.value = mdate.mdl;
				}
				if (module_num.value > 0) {
					buildGroups();
				}
				module_num.addEventListener('change', (e) => {
					buildGroups();
				});
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}

	const buildSemester = () => {
		module_semester.innerHTML = '';
		module_num.innerHTML = '';
		module_groups.innerHTML = '';

		const dataSend = {
			mode: 'semesters',
			module_subject: module_subject.value
		};

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
				module_semester.innerHTML = data.options;
				if (mdate.sem !== undefined) {
					module_semester.value = mdate.sem;
				}
				if (module_semester.value > 0) {
					buildModuleNum();
				}
				module_semester.addEventListener('change', (e) => {
					buildModuleNum();
				});
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}

	const buildSubjects = () => {
		module_subject.innerHTML = '';
		module_semester.innerHTML = '';
		module_num.innerHTML = '';
		module_groups.innerHTML = '';

		const dataSend = {
			mode: 'subjects',
			tutor_id: tutor.value
		};

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
				module_subject.innerHTML = data.options;
				if (mdate.sbj !== undefined) {
					module_subject.value = mdate.sbj;
				}
				if (module_subject.value) {
					buildSemester();
				}
				module_subject.addEventListener('change', (e) => {
					buildSemester();
				});
			}
		})
		.catch(error => console.error('Ошибка:', error));
	}

	if (tutor.value > 0) {
		buildSubjects();
	}
	tutor.addEventListener('change', (e) => {
		buildSubjects();
	});
};