<div>
    <div class="footer-menu">
        <ul>
        @foreach($links as $link)
            <li><a href="{{ $link->link }}">{{ $link->link_name }}</a></li>
        @endforeach
        </ul>
    </div>
    <div class="footer-copylight">
        <p>Copyright © since 2020 Rairacu Co., Ltd. All right reserved.</p>
    </div>
</div>