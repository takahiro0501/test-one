//カレンダー表示
const week = ["日", "月", "火", "水", "木", "金", "土"];
const today = new Date();
// 月末だとずれる可能性があるため、1日固定で取得
let showDate = new Date(today.getFullYear(), today.getMonth(), 1);
//前の週ボタン取得
const prevBtn = document.getElementById('prev');
//日付け変更格納用変数
let changeDate = new Array();
//日付け・スタッフ格納Input要素
const restInput = document.getElementById('restdata');
const staffInput = document.getElementById('staff');


// 初期表示
window.onload = function () {
    //前の週ボタン非活性化
    prevBtn.disabled = true;
    prevBtn.style.backgroundColor = 'grey';
    prevBtn.style.borderColor = 'grey';
    //送信データ
    const targetDate = today.getFullYear() + '-' + ('0' + (Number(today.getMonth()) + 1)).slice(-2);
    //サーバ通信処理
    fetch('calender', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({
            date: targetDate,
            staff: staffInput.value
        })
    })
    .then((response) => {
        return response.json();
    })
    .then((restDatas) => {
        showProcess(today, restDatas);
    })
    .catch(error => {
        console.error('エラーが発生しました', error);
    })
};

// 月変更
function changeMonth(month) {
    //次の週、前の週判定
    if (month == 'prev') {
        showDate.setMonth(showDate.getMonth() - 1);        
    } else if (month == 'next') {
        showDate.setMonth(showDate.getMonth() + 1);
    }
    //前の週ボタン非活性化判定
    let todayDate = today.getFullYear() + '-' + ('0' + (Number(today.getMonth()) + 1)).slice(-2);
    let targetDate = showDate.getFullYear() + '-' + ('0' + (Number(showDate.getMonth()) + 1)).slice(-2);
    if (todayDate == targetDate) {
        prevBtn.disabled = true;
        prevBtn.style.backgroundColor = 'grey';
        prevBtn.style.borderColor = 'grey';
    } else {
        prevBtn.disabled = false;        
        prevBtn.style.backgroundColor = '#B78D4A';
        prevBtn.style.borderColor = '#B78D4A';
    }
    //サーバ通信処理
    fetch('calender', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({
            date: targetDate,
            staff: staffInput.value
        })
    })
    .then((response) => {
        return response.json();
    })
    .then((restDatas) => {
        showProcess(showDate, restDatas);
    })
    .catch(error => {
        console.error('エラーが発生しました', error);
    })
}

// カレンダー表示
function showProcess(date, restDatas) {
    let year = date.getFullYear();
    let month = date.getMonth();
    document.querySelector('#header').innerHTML = year + "年 " + (month + 1) + "月";   
    let calendar = createProcess(year, month, restDatas);
    document.querySelector('#calendar').innerHTML = calendar;
}

function createProcess(year, month, restDatas) {
    // 曜日
    let calendar = "<table><tr class='dayOfWeek'>";
    for (let i = 0; i < week.length; i++) {
        if(i == 0) {
            calendar += "<th class='sunday'>" + week[i] + "</th>";            
        }else if(i == 6){
            calendar += "<th class='saturday'>" + week[i] + "</th>";                        
        }else {
            calendar += "<th>" + week[i] + "</th>";            
        }
    }
    calendar += "</tr>";
    let count = 0;
    let startDayOfWeek = new Date(year, month, 1).getDay();
    let endDate = new Date(year, month + 1, 0).getDate();
    let lastMonthEndDate = new Date(year, month, 0).getDate();
    let row = Math.ceil((startDayOfWeek + endDate) / week.length);

    for (let i = 0; i < row; i++) {
        calendar += "<tr>";
        for (let j = 0; j < week.length; j++) {
            //先月表示の判定
            if (i == 0 && j < startDayOfWeek) {
                calendar += "<td class='disabled'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</td>";
            //次月表示の判定
            } else if (count >= endDate) {
                count++;
                calendar += "<td class='disabled'>" + (count - endDate) + "</td>";
            //今月表示の判定
            } else {
                count++;
                const key = 'd' + count;
                if (restDatas[key] == 'business') {
                    calendar += "<td onclick='changeColor(this," + year + "," + Number(month + 1) + "," + count + ");return false;'><p>" + count + "</p></td> ";
                } else if(restDatas[key] == 'rest') {
                    calendar += "<td class='rest' onclick='changeColor(this," + year + "," + Number(month + 1) + "," + count + ");return false;'><p>" + count + "</p></td> ";
                }
            }
        }
        calendar += "</tr>";
    }
    return calendar;
}

function changeColor(tdObj, year, month, day) {
    const target = year + '-' + ('0' + month).slice(-2) + '-' + ('0' + day).slice(-2);
    const index = changeDate.findIndex(({ date }) => date === target);
    if (tdObj.classList.contains('rest')) {
        tdObj.classList.remove('rest');
        if (index === -1) {
            changeDate.push({
                date: target,
                status: 0
            });
        } else {
            changeDate.splice(index, 1);
        }
    } else {
        tdObj.classList.add('rest');
        if (index === -1) {
            changeDate.push({
                date: target,
                status: 1
            });
        } else {
            changeDate.splice(index, 1);
        }
    }
    restInput.value = JSON.stringify(changeDate);
}
