
function updateComfirm() {
    const result = window.confirm('曜日一括休日設定を変更すると、そのスタッフの個別休日設定が削除され再度設定のし直しが必要になります。よろしいでしょうか？');
    if( result ) {
        return true;
    }
    else {
        return false;
    }    
}

function changeValue(tdInput) {
    tdInput.classList.toggle('change-color');
    if (tdInput.value == '×') {
        tdInput.value = '〇';
    } else if(tdInput.value == '〇'){
        tdInput.value = '×';        
    }
}
