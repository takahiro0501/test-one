//削除ボタン取得
const deleteBtn = document.getElementById('reservationDelete');

function deleteComfirm() {
    const result = window.confirm('予約データを削除します。よろしいでしょうか？');
    if( result ) {
        return true;
    }
    else {
        return false;
    }    
}
