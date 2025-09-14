<style>
    .ck-editor__editable {
        min-height: 200px !important;
    }
    .ck-editor{
        margin-inline: auto !important;
    }
    body{
        --ck-border-radius: 10px;
    }
</style>

<textarea id="{{$name}}" name="{{$name}}" class="{{$name}}">
    {{$value ?: ''}}
</textarea>

@if(isset($word_count) && $word_count === true)
    <div id="word-count"></div>
@endif

<script src="{{asset('js/ckeditor.js')}}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#{{$name}}' ) )
        .then( editor => {
            console.log( editor );

            // Function to update word count
            @if(isset($word_count) && $word_count === true)
            function updateWordCount() {
                const content = editor.getData();
                const words = content.split(/\s+/).filter(function (word) {
                    return word.length > 0;
                }).length;

                // Display word count in a div with id 'word-count'
                document.getElementById('word-count').innerText = 'Word Count: ' + words;
            }

            // Event listener for data changes
            editor.model.document.on("change:data", updateWordCount);

            // Initial word count on page load
            updateWordCount();
            @endif

            @if(isset($remember) && $remember === true)
            // Save and load content from localStorage
            editor.model.document.on("change:data", () => {
                const content = editor.getData();
                localStorage.setItem("editorContent_{{$name}}", content);
            });

            const savedContent = localStorage.getItem("editorContent_{{$name}}");
            if (savedContent) {
                editor.setData(savedContent);
            }
            @endif
        })
        .catch( error => {
            console.error( error );
        });
</script>
