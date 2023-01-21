<h3>いつもご利用ありがとうございます</h3>
<h3>以下のパスワードリセットボタンをクリックしてして下さい。</h3>
<a href="{{ $resetURL }}" rel="nofollow" target="_blank" class="btn">パスワードリセット</a>
<p>
    ※「パスワードリセット」ボタンをがクリックできない場合は以下のURLをコピーしてブラウザに貼り付けてください。<br>
    {{ $resetURL }}
</p>
<p>※こちらのメールは送信専用のメールアドレスより送信しています。恐れ入りますが、直接返信しないようお願いします。</p>

<style>
.btn {
    background-color: #305dff;
    color: white;
    padding: 8px 15px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    text-decoration: none;
}
</style>