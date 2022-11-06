const server = {
    routes: {
        host: 'http://localhost:8000/api/',
        // host: 'http://localhost:8000/',
        api: {
            number_deliveries_month: 'number-deliveries-month',
            number_deliveries: 'number-deliveries',
            total_income: 'total-income',
            percentages: 'percentages',
            shipping_city: 'shipping-city'
        }
    },
    dates: {
        date: () => new Date().toLocaleDateString("es-CO"),
        splitDate: function(index) {
            return parseInt(this.date().split("/")[index]);
        },
        day: function() {
            return this.splitDate(0);
        },
        month: function() {
            return this.splitDate(1);
        },
        year: function() {
            return this.splitDate(2);
        },
        list_months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        list_numbers_month: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    },
    colors: {
        background: [
        'rgba(240, 133, 28)',
        'rgba(211, 225, 222)',
        'rgba(40, 69, 152)',
        'rgba(240, 133, 28)',
        'rgba(211, 225, 222)',
        'rgba(40, 69, 152)'
        ],
        background_opacity: [
        'rgba(240, 133, 28, 0.2)',
        'rgba(211, 225, 222, 0.2)',
        'rgba(40, 69, 152, 0.2)',
        'rgba(240, 133, 28, 0.2)',
        'rgba(211, 225, 222, 0.2)',
        'rgba(40, 69, 152, 0.2)'
        ],
        border: [
        'rgb(240, 133, 28)',
        'rgb(211, 225, 222)',
        'rgb(40, 69, 152)',
        'rgb(240, 133, 28)',
        'rgb(211, 225, 222)',
        'rgb(40, 69, 152)'
        ],
    }
};

const getField = (id) => document.getElementById(id);
const getValueField = (id) => getField(id).value;
const setValueField = (id, value) => getField(id).value = value;
const valueFormat = (num) => num.toLocaleString('es');
const newChart = (id, config) => new Chart(getField(id).getContext('2d'), config);

const getForm = (rows) => {
    const form = new FormData();
    rows.forEach(row => form.append(row.id, row.value));
    return form;
};

const getRandomInt = (min, max) => {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min) + min);
};

const filterEspecialChar = (str) => {
    str = str.toLowerCase().trim();
    str = str.replace(/á/gm, 'a');
    str = str.replace(/é/gm, 'e');
    str = str.replace(/í/gm, 'i');
    str = str.replace(/ó/gm, 'o');
    str = str.replace(/ú/gm, 'u');
    return str.replace(/\b\w/g, l => l.toUpperCase()).trim();
};

const uploadSelect = (id_select, list_value) => {
	const select = getField(id_select);
	let index = 0;

    for (let year of list_value) { //.reverse()
        const option = document.createElement('OPTION');
        option.value = year;
        option.textContent = year;

        if (index === 0) {
            index = 1;
            option.setAttribute('selected', 'selected');
        }

        select.appendChild(option);
    }
};

const update_new_list = (new_list, obj, select) => {
    new_list = [];
    const data = obj[select.value];

    if (![null, false, undefined, ''].includes(data)) {
        const all_info = Object.entries(data)
            .map(info => info.pop())
            .map(info => info);

        for (let all of all_info) {
            new_list.push(...all);
        }
    }

    return new_list;
};

const updateChart = (id) => {
    getField(id).remove();
    const canvas = document.createElement('CANVAS');
    canvas.id = id;
    getField('container-' + id).appendChild(canvas);
};