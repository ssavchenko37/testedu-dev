"use strict"

const restoreFilters = () => {
    const viewButtons = document.getElementsByClassName('get-book');
    for(let btn of viewButtons) {
        btn.addEventListener('click', () => {
            const data = {};
            document.getElementById('frm0').querySelectorAll('select').forEach(s => data[s.name] = s.value);
            localStorage.setItem('filterValues', JSON.stringify(data));
        });
    }	

    const saved = localStorage.getItem('filterValues');
    if (saved) {
        const data = JSON.parse(saved);
        document.querySelectorAll('select').forEach(s => {
            if (data[s.name]) {
                s.value = data[s.name];
                if (s.value > 0) {
                    s.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
    }
    localStorage.removeItem('filterValues');
}
docReady(restoreFilters);