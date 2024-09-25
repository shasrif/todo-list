<div class="form-group">
    <input type="hidden" id="post_id" name="id" value="{{ $post->id }}">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter title" value="{{ $post->title }}">
</div>
<div class="form-group">
    <label for="body">Content</label>
    <textarea class="form-control" id="edit_body" name="body" placeholder="Enter content">{{ $post->body }}</textarea>
</div>