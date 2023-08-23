<i class="fas fa-heart text-pink-500"></i>
{{-- <div class  h></div> --}}
<p>{{ $notification->data['user_name'] }}さんにいいねされました。</p>
<p>post_id:{{ $notification->data['liked_post']}}の投稿です。</p>
{{-- その他の通知タイプに特有の表示ロジック --}}