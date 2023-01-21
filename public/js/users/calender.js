//カレンダー表示
const week = ["日", "月", "火", "水", "木", "金", "土"];
const today = new Date();
// 月末だとずれる可能性があるため、1日固定で取得
let showDate = new Date(today.getFullYear(), today.getMonth(), 1);
//前の週ボタン取得
const prevBtn = document.getElementById('prev');

// 初期表示
window.onload = function () {
    //前の週ボタン非活性化
    prevBtn.disabled = true;
    prevBtn.style.backgroundColor = 'grey';
    prevBtn.style.borderColor = 'grey';
    //送信データ
    const targetMonth = ('0' + (Number(today.getMonth()) + 1)).slice(-2);
    const targetDay = ( '0' + today.getDate()).slice(-2);
    const targetDate = today.getFullYear() + '-' + targetMonth + '-' + targetDay;
    const staffId = document.getElementById("staffParam");
    const menuId = document.getElementById("menuParam");
    let param;
    if (staffId != null) {
        param = [{ 'date': targetDate, 'staff': staffId.value, 'menu': menuId.value }];
    } else {
        param = [{ 'date': targetDate, 'staff': null, 'menu': null }];             
    }
    //サーバ通信処理
    fetch('show', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify(param)
    })
    .then((response) => {
        return response.json();
    })
    .then((reservationData) => {
        console.log(reservationData);
        showProcess(today, reservationData);
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
        targetDate = showDate.getFullYear() + '-' + ('0' + (Number(showDate.getMonth()) + 1)).slice(-2) + '-' + ( '0' + today.getDate()).slice(-2);
    } else {
        prevBtn.disabled = false;        
        prevBtn.style.backgroundColor = '#B78D4A';
        prevBtn.style.borderColor = '#B78D4A';
        targetDate = showDate.getFullYear() + '-' + ('0' + (Number(showDate.getMonth()) + 1)).slice(-2);
    }
    //送信データ作成
    const staffId = document.getElementById("staffParam");
    const menuId = document.getElementById("menuParam");
    let param;
    if (staffId != null) {
        param = [{ 'date': targetDate, 'staff': staffId.value, 'menu': menuId.value }];
    } else {
        param = [{ 'date': targetDate, 'staff': null, 'menu': null }];             
    }
    //サーバ通信処理
    fetch('show', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify(param)
    })
    .then((response) => {
        return response.json();
    })
    .then((reservationData) => {
        showProcess(showDate, reservationData);
    })
    .catch(error => {
        console.error('エラーが発生しました', error);
    })
}

// カレンダー表示
function showProcess(date,reservationData) {
    let year = date.getFullYear();
    let month = date.getMonth();
    document.querySelector('#header').innerHTML = year + "年 " + (month + 1) + "月";   
    let calendar = createProcess(year, month, reservationData);
    document.querySelector('#calendar').innerHTML = calendar;
}

function createProcess(year, month, rData) {
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
            //先月日表示の判定
            if (i == 0 && j < startDayOfWeek) {
                calendar += "<td class='disabled'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</td>";
            //次月日表示の判定
            } else if (count >= endDate) {
                count++;
                calendar += "<td class='disabled'>" + (count - endDate) + "</td>";
            //今月日表示の判定
            } else {
                count++;
                let key = 'd' + count;
                let date = year  + ('0' + Number(month + 1)).slice(-2) + ('0' + count).slice(-2);
                if(year == today.getFullYear() && month == (today.getMonth()) && count == today.getDate()) {
                    if (rData[key] == '－') {
                        calendar += "<td class='today'><p>" + count + "</p><p>" + rData[key] + "</p ></td > ";                        
                    } else {
                        calendar += "<td class='today day'><a href='javascript:calendarSubmit(" + date + ");'><p>" + count + "</p><p>" + rData[key] + "</p ></a></td> ";
                    }
                } else {
                    if (rData[key] == '－') {
                        calendar += "<td><p>" + count + "</p><p>" + rData[key] + "</p ></td > ";
                    } else {
                        calendar += "<td class='day'><a href='javascript:calendarSubmit(" + date + ");'><p>" + count + "</p><p>" + rData[key] + "</p ></a></td> ";
                    }
                }
            }
        }
        calendar += "</tr>";
    }
    return calendar;
}

function calendarSubmit(date) {
    const str = String(date);
    const year = str.slice(0, 4);
    const month = str.slice(4, 6);
    const day = str.slice(6, 8);
    const cFrom = document.getElementById('calenderForm');
    const cParam = document.getElementById('cParam');
    cParam.value = cParam.value + year + '-' + month + '-' + day;
    cFrom.submit();
}


