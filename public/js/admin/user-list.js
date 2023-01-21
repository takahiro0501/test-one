//削除ボタン取得
const deleteBtn = document.getElementById('userDelete');

function deleteComfirm() {
    const result = window.confirm('ユーザデータを削除します。ユーザデータを削除すると、紐づく予約データも削除されます。よろしいでしょうか？');
    if( result ) {
        return true;
    }
    else {
        return false;
    }    
}
