@if($post->type === 'video' && $post->youtube_id)
    <div class="aspect-video">
        <iframe class="w-full h-full rounded-xl"
            src="https://www.youtube.com/embed/{{ $post->youtube_id }}"
            allowfullscreen>
        </iframe>
    </div>
@endif