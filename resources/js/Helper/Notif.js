alert('hello gaisss')

console.log(new Date())

function formatDate(date = new Date()) {
    const year = date.toLocaleString('default', {year: 'numeric'});
    const month = date.toLocaleString('default', {month: '2-digit'});
    const day = date.toLocaleString('default', {day: '2-digit'});
  
    return [year, month, day].join('-');
}

const this_day = formatDate(new Date())

setInterval(() => {
    fetch('https://kosakatakita.online/getNotification')
        .then((response) => response.text())
        .then((response) => {
            const data = JSON.parse(response)
            Push.create(data[data.bahasa], {
                timeout: 10000
            })
            console.log(data[data.bahasa])
        })
        .catch((err) => console.log(err))
}, 1200000);